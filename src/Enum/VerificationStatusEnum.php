<?php

declare(strict_types=1);

namespace App\Enum;

enum VerificationStatusEnum: string
{
    case DRAFT     = 'DRAFT';
    case SUBMITTED = 'SUBMITTED';
    case APPROVED  = 'APPROVED';
    case REJECTED  = 'REJECTED';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT     => 'Brouillon',
            self::SUBMITTED => 'En cours de vérification',
            self::APPROVED  => 'Validée',
            self::REJECTED  => 'Refusée',
        };
    }
}
