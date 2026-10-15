<?php
declare(strict_types=1);
namespace App\Enum;

enum TransactionStatusEnum: string
{
        case PENDING  = 'PENDING';
        case VALIDATED  = 'VALIDATED';
        case CANCELED = 'CANCELED';


     public function label() : string {
        return match($this){
            self::CANCELED => 'Annulé',
            self::PENDING => 'En attente',
            self::VALIDATED => 'Validé'
        };
     }

     public static function getChoices(): array {
        $out = [];
        foreach(self::cases() as $case){
            $out[$case->label()] = $case->value;
        }
        return $out;
     }
}