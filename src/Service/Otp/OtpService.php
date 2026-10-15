<?php

declare(strict_types=1);

namespace App\Service\Otp;

use App\Entity\User;
use App\Service\Sms\Dto\SmsMessage;
use App\Service\Sms\Exception\SmsDeliveryException;
use App\Service\Sms\SmsFactor\SmsFactorSmsService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * Cycle de vie du code de validation (OTP) à usage unique.
 *
 * Décisions de sécurité :
 *  - le code est généré avec random_int() (CSPRNG), jamais rand()/mt_rand() ;
 *  - seul son HASH est écrit dans User::validationCode — une fuite de la base
 *    ne permet pas de rejouer un OTP en vol ;
 *  - la comparaison passe par password_verify(), donc à temps constant ;
 *  - le code est invalidé dès la première vérification réussie (usage unique)
 *    et après OTP_MAX_ATTEMPTS échecs, pour couper le bruteforce en ligne ;
 *  - l'échec « code faux » et l'échec « code expiré » renvoient un message
 *    volontairement identique côté contrôleur, pour ne rien divulguer.
 */
final class OtpService
{
    public const OTP_LENGTH = 6;
    public const OTP_TTL_SECONDS = 300;   // 5 minutes, comme spécifié
    public const OTP_MAX_ATTEMPTS = 5;
    public const OTP_RESEND_COOLDOWN = 60; // 1 minute entre deux renvois

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly SmsFactorSmsService $smsSender,
        private readonly MailerInterface $mailer,
        private readonly LoggerInterface $logger,
        #[Autowire('%env(MAILER_FROM)%')]
        private readonly string $mailerFrom = 'no-reply@NexoBanq.com',
    ) {
    }

    /**
     * Génère un OTP, le persiste haché et l'envoie par SMS + e-mail.
     *
     * @return OtpDispatchResult état d'acheminement par canal
     */
    public function issue(User $user): OtpDispatchResult
    {
        $code = $this->generateCode();

        $user->setValidationCode(password_hash($code, \PASSWORD_BCRYPT));
        $user->setValidationDate(new \DateTimeImmutable());
        $user->setValidationAttemptCount(0);
        $user->touch();

        $this->em->flush();

        $smsSent = $this->dispatchSms($user, $code);
        $emailSent = $this->dispatchEmail($user, $code);

        // On efface la variable locale au plus tôt.
        sodium_memzero($code);

        if (!$smsSent && !$emailSent) {
            $this->logger->error('Aucun canal n\'a pu acheminer l\'OTP.', [
                'user' => $user->getId()->toRfc4122(),
            ]);
        }

        return new OtpDispatchResult($smsSent, $emailSent);
    }

    /**
     * Vérifie le code saisi et consomme l'OTP en cas de succès.
     */
    public function verify(User $user, string $submittedCode): OtpVerificationResult
    {
        $submittedCode = preg_replace('/\D/', '', $submittedCode) ?? '';

        if (null === $user->getValidationCode() || null === $user->getValidationDate()) {
            return OtpVerificationResult::NO_PENDING_CODE;
        }

        if ($user->isOtpExpired(self::OTP_TTL_SECONDS)) {
            $user->clearOtp();
            $this->em->flush();

            return OtpVerificationResult::EXPIRED;
        }

        if ($user->getValidationAttemptCount() >= self::OTP_MAX_ATTEMPTS) {
            $user->clearOtp();
            $this->em->flush();

            $this->logger->warning('OTP invalidé : trop de tentatives.', [
                'user' => $user->getId()->toRfc4122(),
            ]);

            return OtpVerificationResult::TOO_MANY_ATTEMPTS;
        }

        if (!password_verify($submittedCode, $user->getValidationCode())) {
            $user->incrementValidationAttemptCount();
            $this->em->flush();

            return OtpVerificationResult::INVALID;
        }

        // Succès : l'OTP est consommé immédiatement (usage unique).
        $user->clearOtp();
        $user->setLastLoginAt(new \DateTimeImmutable());
        $user->setPasswordAttemptCount(0);
        $user->touch();
        $this->em->flush();

        return OtpVerificationResult::VALID;
    }

    /**
     * Un renvoi n'est autorisé qu'après OTP_RESEND_COOLDOWN secondes,
     * afin d'éviter qu'on se serve de l'endpoint comme d'un canal de spam SMS
     * (chaque SMS a un coût réel chez Twilio / SMSFactor).
     */
    public function canResend(User $user): bool
    {
        $issuedAt = $user->getValidationDate();

        if (null === $issuedAt) {
            return true;
        }

        return $issuedAt->getTimestamp() + self::OTP_RESEND_COOLDOWN <= time();
    }

    public function secondsBeforeResend(User $user): int
    {
        $issuedAt = $user->getValidationDate();

        if (null === $issuedAt) {
            return 0;
        }

        return max(0, $issuedAt->getTimestamp() + self::OTP_RESEND_COOLDOWN - time());
    }

    private function generateCode(): string
    {
        $max = 10 ** self::OTP_LENGTH - 1;
        return str_pad((string) random_int(0, $max), self::OTP_LENGTH, '0', \STR_PAD_LEFT);
    }

    private function dispatchSms(User $user, string $code): bool
    {
        $customer = $user->getCustomer();
        $phone = $customer?->getPhoneCountryCode().$customer?->getPhoneNumber();
        if (null === $phone || '' === $phone) {
            return false;
        }
        $message = \sprintf(
            'NexoBanq : votre code de connexion est %s. Il expire dans %d minutes. Ne le communiquez a personne.',
            $code,
            (int) (self::OTP_TTL_SECONDS / 60)
        );

        try {
            $this->smsSender->send(new SmsMessage($phone,$message,'NexoBanq',[],null,[]));
            return true;
        } catch (SmsDeliveryException $e) {
            $this->logger->error('Envoi OTP par SMS impossible.', [
                'user' => $user->getId()->toRfc4122(),
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function dispatchEmail(User $user, string $code): bool
    {
        $customer = $user->getCustomer();
        $email = $customer?->getEmail();

        if (null === $email || '' === $email) {
            return false;
        }

        try {
            $message = (new TemplatedEmail())
                ->from(new Address($this->mailerFrom, 'NexoBanq'))
                ->to(new Address($email, trim($customer->getFirstname().' '.$customer->getLastname())))
                ->subject('Votre code de connexion NexoBanq')
                ->htmlTemplate('emails/otp.html.twig')
                ->context([
                    'code' => $code,
                    'ttlMinutes' => (int) (self::OTP_TTL_SECONDS / 60),
                    'firstname' => $customer->getFirstname(),
                ]);

            $this->mailer->send($message);
            return true;
        } catch (TransportExceptionInterface $e) {
            $this->logger->error('Envoi OTP par e-mail impossible.', [
                'user' => $user->getId()->toRfc4122(),
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
