<?php
declare(strict_types=1);
namespace App\Enum;

enum EmploymentTypeEnum: string
{
     case CDI = 'CDI';
     case CDD = 'CDD';

    public function getLabel(): string {
        return match($this){
            self::CDI => 'CDI',
            self::CDD => 'CDD',
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