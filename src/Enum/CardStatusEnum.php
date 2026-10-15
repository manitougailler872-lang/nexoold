<?php
declare(strict_types=1);
namespace App\Enum;

enum CardStatusEnum: string
{
    case ACTIVATED = 'ACTIVATED';
    case DESACTIVATED = 'DESACTIVATED';
    case BLOCKED = 'BLOCKED';
    case FREEZE = 'FREEZE';
    case PENDING  = 'PENDING';

    public function getLabel(): string {
        return match($this){
            self::ACTIVATED => 'Activé',
            self::DESACTIVATED => 'Désactivé',
            self::BLOCKED =>  'Bloqué',
            self::FREEZE =>  'Gelé',
            self::PENDING =>  'En attente'
        };
    }

    public static function getChoices():array {
        $out = [];
        foreach(self::cases() as $case){
            $out[$case->getLabel()] = $case->value; 
        }
        return $out;
    }
}