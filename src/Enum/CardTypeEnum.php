<?php
declare(strict_types=1);
namespace App\Enum;

enum CardTypeEnum: string
{
    case NEXO = 'NEXO';
    case PRO = 'PRO';
    case ELITE = 'ELITE';

    public function getLabel(): string {
        return match($this){
            self::NEXO => 'Carte Nexo',
            self::PRO => 'Carte Virtuelle Nexo Pro',
            self::ELITE => 'Carte Nexo Elite',
        };
    }

    public function getSubLabel(): string {
        return match($this){
            self::NEXO => 'Carte principale · EUR',
            self::PRO => 'Paiements en ligne uniquement',
            self::ELITE => 'Paiements en ligne uniquement',
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