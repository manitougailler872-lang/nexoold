<?php

declare(strict_types=1);

namespace App\Enum;

enum TypeAlerteEnum: string
{
    case SECURITY = 'SECURITY';
    case ACCOUNT = 'ACCOUNT';
    case TRANSACTION = 'TRANSACTION';
    case INFO = 'INFO';

    public function label(): string
    {
        return match ($this) {
            self::SECURITY => 'Sécurité',
            self::ACCOUNT => 'Compte',
            self::TRANSACTION => 'Transaction',
            self::INFO => 'Information',
        };
    }
}
