<?php
declare(strict_types=1);
namespace App\Enum;

enum AccountCategoryEnum: string
{
     case TRAVEL  = 'TRAVEL';
     case EXPENSE  = 'EXPENSE';
     case EPARGNE = 'EPARGNE';


     public function getLabel() : string {
        return match($this){
            self::EPARGNE => 'Epargne',
            self::TRAVEL => 'Voyages',
            self::EXPENSE => 'Dépenses'
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