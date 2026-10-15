<?php
declare(strict_types=1);
namespace App\Enum;

enum AccountStatusEnum: string
{
     case PENDING  = 'PENDING';
     case VALIDATED  = 'VALIDATED';
     case BLOCKED = 'BLOCKED';


     public function label() : string {
        return match($this){
            self::BLOCKED => 'Bloqué',
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