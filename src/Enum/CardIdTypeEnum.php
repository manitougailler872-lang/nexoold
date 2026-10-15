<?php
declare(strict_types=1);
namespace App\Enum;

enum CardIdTypeEnum: string
{
    case CARD_ID = 'CARD_ID';
    case PASSEPORT = 'PASSEPORT';

    public function getLabel(): string {
        return match($this){
            self::CARD_ID => 'Pièce d\'identité',
            self::PASSEPORT => 'Passeport',
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