<?php

declare(strict_types=1);

namespace App\Enum;

enum DocumentTypeEnum: string
{
    case IDENTITY_CARD    = 'IDENTITY_CARD';
    case PASSPORT         = 'PASSPORT';
    case PROOF_OF_ADDRESS = 'PROOF_OF_ADDRESS';
    case PAYSLIP          = 'PAYSLIP';
    case TAX_NOTICE       = 'TAX_NOTICE';
    case RIB              = 'RIB';

    public function label(): string
    {
        return match ($this) {
            self::IDENTITY_CARD    => "Pièce d'identité",
            self::PASSPORT         => 'Passeport',
            self::PROOF_OF_ADDRESS => 'Justificatif de domicile (moins de 3 mois)',
            self::PAYSLIP          => 'Fiche de paie',
            self::TAX_NOTICE       => "Avis d'imposition",
            self::RIB              => "Relevé d'identité bancaire",
        };
    }
}
