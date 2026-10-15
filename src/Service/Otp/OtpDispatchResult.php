<?php

declare(strict_types=1);

namespace App\Service\Otp;

final readonly class OtpDispatchResult
{
    public function __construct(
        public bool $smsSent,
        public bool $emailSent,
    ) {
    }

    public function anySent(): bool
    {
        return $this->smsSent || $this->emailSent;
    }

    /** Résumé destiné à l'utilisateur, sans détail technique exploitable. */
    public function userMessage(): string
    {
        return match (true) {
            $this->smsSent && $this->emailSent => 'Un code vous a été envoyé par SMS et par e-mail.',
            $this->smsSent                     => 'Un code vous a été envoyé par SMS.',
            $this->emailSent                   => 'Un code vous a été envoyé par e-mail.',
            default                            => "Le code n'a pas pu être envoyé. Contactez le service client.",
        };
    }
}
