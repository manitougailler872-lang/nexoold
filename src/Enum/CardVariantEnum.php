<?php
declare(strict_types=1);
namespace App\Enum;

enum CardVariantEnum: string
{
    case EMERALD = 'bank-card--emerald';
    case EMERALD_BRIGHT = 'bank-card--emerald-bright';
    case EMERALD_DEEP = 'bank-card--emerald-deep';

    public function getLabel(): string {
        return match($this){
            self::EMERALD => 'bank-card--emerald',
            self::EMERALD_BRIGHT => 'bank-card--emerald-bright',
            self::EMERALD_DEEP => 'bank-card--emerald-deep',
        };
    }

    public function getGaugeColor(): string {
        return match($this){
            self::EMERALD => '#4ADE80',
            self::EMERALD_BRIGHT => '#FFFFFF',
            self::EMERALD_DEEP => 'Paiements en ligne uniquement',
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