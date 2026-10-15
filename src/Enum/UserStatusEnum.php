<?php
declare(strict_types=1);
namespace App\Enum;

enum UserStatusEnum: string
{
    case PENDING = 'PENDING';
    case VALIDATED = 'VALIDATED';
    case AUTHORIZE = 'AUTHORIZE';
    case BLOCKED = 'BLOCKED';

    public function getLabel(): string {
         return match($this) {
             self::AUTHORIZE => 'Autorisé',
             self::BLOCKED => 'Bloqué',
             self::PENDING => 'En attente',
             self::VALIDATED => 'Validé'
         };
    }

    public static function getChoices(): array {
        $out = [];
        foreach(self::cases() as $case){
            $out[$case->getLabel()] = $case->value;
        }
        return $out;
    }  
}