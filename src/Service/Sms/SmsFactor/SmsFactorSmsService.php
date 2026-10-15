<?php

declare(strict_types=1);

namespace App\Service\Sms\SmsFactor;

use App\Service\Sms\Dto\SmsMessage;
use App\Service\Sms\Dto\SmsResult;
use App\Service\Sms\Exception\SmsFactorApiException;
use App\Service\Sms\Exception\SmsSendingFailedException;
use App\Service\Sms\SmsServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface as HttpExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Implémentation "pro" du service SMS basée sur l'API REST SMSFactor
 * (https://dev.smsfactor.com/fr/api/sms/bien-commencer).
 *
 * Fonctionnalités :
 *  - Authentification Bearer
 *  - Envoi unitaire ou multi-destinataires (POST /send, format "campagne")
 *  - Retry avec backoff exponentiel sur erreurs réseau / 5xx
 *  - Mode "test" (dry-run local, l'API SMSFactor n'a pas de sandbox native) pour dev/staging
 *  - Distinction pushtype "alert" (transactionnel) / "marketing"
 *  - Lecture fine de la réponse (cost, sent, blacklisted, flood, invalid...)
 *
 * ⚠️ Particularité SMSFactor : un statut -8 dans la réponse ne signifie PAS
 * un échec définitif (cf. doc officielle) — il est donc traité comme un succès
 * partiel, journalisé, mais pas retenté.
 */
final class SmsFactorSmsService implements SmsServiceInterface
{
    private const BASE_URL = 'https://api.smsfactor.com';
    private const MAX_RETRIES = 3;
    private const BASE_BACKOFF_MS = 300;
    private const RETRYABLE_HTTP_CODES = [500, 502, 503, 504];
    private const STATUS_NON_BLOCKING = -8; // cf. doc : ne pas retenter

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $apiToken,
        private readonly string $defaultSender,
        private readonly LoggerInterface $logger,
        /** true en dev/staging : aucun appel réel à l'API, tout est loggé */
        private readonly bool $sandboxMode = false,
        /** 'alert' (transactionnel, prioritaire) ou 'marketing' */
        private readonly string $defaultPushType = 'alert',
    ) {
    }

    public function send(SmsMessage $message): SmsResult
    {
        $payload = $this->buildSinglePayload($message);

        if ($this->sandboxMode) {
            return $this->sandboxResult($message->to, $payload);
        }

        return $this->doSend($payload, $message->to, $message->templateKey);
    }

    /**
     * @param SmsMessage[] $messages
     *
     * @return SmsResult[]
     */
    public function sendBulk(array $messages): array
    {
        $results = [];
        foreach ($messages as $index => $message) {
            $results[$index] = $this->send($message);
        }

        return $results;
    }

    /**
     * Envoi natif à plusieurs destinataires en un seul appel API ("campagne"),
     * avec un `gsmsmsid` par destinataire pour relier chaque AR reçu via webhook.
     *
     * @param array<string,string> $recipients [gsmsmsid => numéro]
     */
    public function sendCampaign(array $recipients, string $text, ?string $sender = null, ?\DateTimeImmutable $delay = null): SmsResult
    {
        $gsm = [];
        foreach ($recipients as $gsmsmsid => $number) {
            $gsm[] = ['gsmsmsid' => (string) $gsmsmsid, 'value' => $number];
        }

        $payload = [
            'sms' => [
                'message' => array_filter([
                    'text' => $text,
                    'pushtype' => $this->defaultPushType,
                    'sender' => $sender ?? $this->defaultSender,
                    'delay' => $delay?->format('Y-m-d H:i:s'),
                    'unicode' => $this->needsUnicode($text) ? 1 : 0,
                ], static fn ($v) => $v !== null),
            ],
            'recipients' => ['gsm' => $gsm],
        ];

        $toForLog = implode(',', array_values($recipients));

        if ($this->sandboxMode) {
            return $this->sandboxResult($toForLog, $payload);
        }

        return $this->doSend($payload, $toForLog, null, wrapped: true);
    }

    public function getStatus(string $ticket): SmsResult
    {
        // SMSFactor ne propose pas de "GET /send/{ticket}" pour un statut instantané :
        // le suivi se fait via les webhooks DLR (voir SmsFactorWebhookController)
        // ou l'historique de campagne. On journalise et on renvoie un résultat neutre.
        $this->logger->info('[SMSFactor] getStatus() : pas de polling natif, utilisez les webhooks DLR.', ['ticket' => $ticket]);

        return SmsResult::failure('Le statut détaillé n\'est disponible que via webhook DLR ou GET /campaign/{ticket}.', to: null);
    }

    public function getCredits(): int
    {
        $response = $this->request('GET', '/credits');

        return (int) $response['credits'];
    }

    /**
     * @return array<string,mixed>
     */
    private function buildSinglePayload(SmsMessage $message): array
    {
        return array_filter([
            'text' => $message->body,
            'to' => $message->to,
            'sender' => $message->from ?? $this->defaultSender,
            'pushtype' => $this->defaultPushType,
            'unicode' => $this->needsUnicode($message->body) ? 1 : 0,
        ], static fn ($v) => $v !== null && $v !== '');
    }

    /**
     * @param array<string,mixed> $payload
     */
    private function doSend(array $payload, string $toForLog, ?string $templateKey, bool $wrapped = false): SmsResult
    {
        $attempt = 0;
        $lastException = null;

        while ($attempt < self::MAX_RETRIES) {
            $attempt++;

            try {
                $response = $wrapped
                    ? $this->request('POST', '/send', body: $payload)
                    : $this->request('GET', '/send', query: $payload);

                $apiStatus = (int) ($response['status'] ?? 0);

                if ($apiStatus !== 1 && $apiStatus !== self::STATUS_NON_BLOCKING) {
                    throw SmsFactorApiException::fromResponse(
                        (string) ($response['message'] ?? 'Erreur inconnue SMSFactor.'),
                        $apiStatus,
                        200,
                    );
                }

                $this->logger->info('[SMSFactor] Envoi réussi', [
                    'ticket' => $response['ticket'] ?? null,
                    'to' => $toForLog,
                    'template' => $templateKey,
                    'apiStatus' => $apiStatus,
                    'sent' => $response['sent'] ?? null,
                    'flood' => $response['flood'] ?? null,
                    'blacklisted' => $response['blacklisted'] ?? null,
                    'attempt' => $attempt,
                ]);

                return SmsResult::success(
                    sid: (string) ($response['ticket'] ?? ''),
                    status: $apiStatus === self::STATUS_NON_BLOCKING ? 'accepted_pending' : 'sent',
                    to: $toForLog,
                    from: (string) ($payload['sender'] ?? ($payload['sms']['message']['sender'] ?? $this->defaultSender)),
                    price: isset($response['cost']) ? (float) $response['cost'] : null,
                    priceUnit: 'credits',
                );
            } catch (SmsFactorApiException $e) {
                $lastException = $e;
                $isRetryable = in_array($e->getHttpStatus(), self::RETRYABLE_HTTP_CODES, true);

                $this->logger->warning('[SMSFactor] Échec tentative', [
                    'to' => $toForLog,
                    'attempt' => $attempt,
                    'apiStatus' => $e->getApiStatus(),
                    'httpStatus' => $e->getHttpStatus(),
                    'message' => $e->getMessage(),
                    'retryable' => $isRetryable,
                ]);

                if (!$isRetryable || $attempt >= self::MAX_RETRIES) {
                    break;
                }

                usleep((int) (self::BASE_BACKOFF_MS * 2 ** ($attempt - 1) * 1000));
            }
        }

        $exception = SmsSendingFailedException::afterRetries($toForLog, $attempt, $lastException ?? new \RuntimeException('Erreur inconnue'));
        $this->logger->error('[SMSFactor] Envoi abandonné', ['to' => $toForLog, 'error' => $exception->getMessage()]);

        return SmsResult::failure(
            errorMessage: $exception->getMessage(),
            errorCode: $lastException instanceof SmsFactorApiException ? (string) $lastException->getApiStatus() : null,
            to: $toForLog,
        );
    }

    /**
     * @param array<string,mixed> $payload
     */
    private function sandboxResult(string $to, array $payload): SmsResult
    {
        $this->logger->info('[SMSFactor][SANDBOX] Envoi simulé', ['to' => $to, 'payload' => $payload]);

        return SmsResult::success(
            sid: 'SANDBOX-' . bin2hex(random_bytes(8)),
            status: 'sandbox',
            to: $to,
            from: $this->defaultSender,
        );
    }

    /**
     * @param array<string,mixed>|null $body
     * @param array<string,mixed>|null $query
     *
     * @return array<string,mixed>
     */
    private function request(string $method, string $path, ?array $body = null, ?array $query = null): array
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Accept' => 'application/json',
        ];

        try {
            $options = ['headers' => $headers];
            if ($body !== null) {
                $options['json'] = $body;
            }
            if ($query !== null) {
                // L'API accepte aussi le token en query, mais on privilégie le header Authorization.
                $options['query'] = $query;
            }

            $response = $this->httpClient->request($method, self::BASE_URL . $path, $options);
            $statusCode = $response->getStatusCode();
            $data = $response->toArray(false);

            if ($statusCode >= 400) {
                throw SmsFactorApiException::fromResponse(
                    (string) ($data['message'] ?? 'Erreur HTTP SMSFactor.'),
                    isset($data['status']) ? (int) $data['status'] : null,
                    $statusCode,
                );
            }

            return $data;
        } catch (SmsFactorApiException $e) {
            throw $e;
        } catch (TransportException $e) {
            throw SmsFactorApiException::fromResponse('Erreur réseau vers l\'API SMSFactor : ' . $e->getMessage(), null, 503);
        } catch (HttpExceptionInterface $e) {
            throw SmsFactorApiException::fromResponse('Erreur HTTP vers l\'API SMSFactor : ' . $e->getMessage(), null, null);
        }
    }

    private function needsUnicode(string $text): bool
    {
        // GSM-7 ne couvre pas les emojis ni les caractères non latins (arabe, cyrillique...).
        // On force unicode=1 dès qu'un caractère hors GSM-7 étendu est détecté.
        return (bool) preg_match('/[^\x00-\x7F\x{20AC}àâäéèêëîïôöùûüçÀÂÄÉÈÊËÎÏÔÖÙÛÜÇ]/u', $text);
    }
}
