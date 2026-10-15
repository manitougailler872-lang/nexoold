<?php

declare(strict_types=1);

namespace App\Service\Sms\Dto;

/**
 * Représente un SMS à envoyer.
 * Peut être construit directement, ou via un template (voir SmsTemplateManager).
 */
final class SmsMessage
{
    /**
     * @param string      $to        Numéro destinataire au format E.164 (ex: +22997000000)
     * @param string      $body      Contenu du message (déjà rendu si issu d'un template)
     * @param string|null $from      Numéro expéditeur (sinon TWILIO_FROM_NUMBER par défaut)
     * @param string[]    $mediaUrls URLs de médias pour un MMS (optionnel)
     * @param string|null $templateKey Clé du template utilisé (pour traçabilité/logs)
     * @param array<string,mixed> $context Contexte métier (ex: ['reservationId' => 123])
     */
    public function __construct(
        public readonly string $to,
        public readonly string $body,
        public readonly ?string $from = null,
        public readonly array $mediaUrls = [],
        public readonly ?string $templateKey = null,
        public readonly array $context = [],
    ) {
    }

    public static function create(string $to, string $body, ?string $from = null): self
    {
        return new self($to, $body, $from);
    }
}
