<?php
declare(strict_types=1);
namespace App\Enum;

enum AccountTypeEnum: string
{
     case NEXO  = 'NEXO';
     case EPARGNE_NEXO  = 'EPARGNE_NEXO';
     case NEXO_PRO = 'NEXO_PRO';


     public function getLabel() : string {
        return match($this){
            self::NEXO => 'Compte Nexo',
            self::EPARGNE_NEXO => 'Compte Epargne+',
            self::NEXO_PRO => 'Compte Nexo Pro'
        };
     }

     public function getDescription() : string {
        return match($this){
            self::NEXO => 'Compte Nexo',
            self::EPARGNE_NEXO => 'Compte Epargne+',
            self::NEXO_PRO => 'Compte Nexo Pro'
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