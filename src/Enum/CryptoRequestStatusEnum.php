<?php

declare(strict_types=1);

namespace App\Enum;

enum CryptoRequestStatusEnum: string
{
    case PENDING = 'PENDING';
    case VALIDATED = 'VALIDATED';
    case CANCELED = 'CANCELED';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::VALIDATED => 'Validée',
            self::CANCELED => 'Annulée',
        };
    }
}
