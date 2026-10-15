<?php

declare(strict_types=1);

namespace App\Service\Otp;

enum OtpVerificationResult
{
    case VALID;
    case INVALID;
    case EXPIRED;
    case TOO_MANY_ATTEMPTS;
    case NO_PENDING_CODE;

    public function isSuccess(): bool
    {
        return self::VALID === $this;
    }

    /**
     * Message affiché à l'utilisateur.
     *
     * INVALID et EXPIRED partagent volontairement le même libellé : distinguer
     * les deux cas indiquerait à un attaquant si un code encore valide existe.
     */
    public function userMessage(): string
    {
        return match ($this) {
            self::VALID             => 'Code validé.',
            self::INVALID,
            self::EXPIRED           => 'Code incorrect ou expiré. Demandez un nouveau code si nécessaire.',
            self::TOO_MANY_ATTEMPTS => 'Trop de tentatives. Un nouveau code doit être demandé.',
            self::NO_PENDING_CODE   => 'Aucun code en attente. Reprenez la connexion.',
        };
    }
}
