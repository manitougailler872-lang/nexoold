<?php
declare(strict_types=1);
namespace App\Enum;

enum GenderEnum: string
{
     case MALE = 'MALE';
     case FEMALE = 'FEMALE';
     case OTHER = 'OTHER';

     public function getLabel():string {
        return match($this){
            self::MALE => 'MALE',
            self::FEMALE => 'FEMALE',
            self::OTHER =>'OTHER'
        };
     }

     public function getChoices():array {
        $out = [];
        foreach(self::cases() as $case){
            $out[$case->getLabel()] = $case->value;
        }
        return $out;
     }
}