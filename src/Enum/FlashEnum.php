<?php
declare(strict_types=1);
namespace App\Enum;

enum FlashEnum: string
{
     case DANGER = 'DANGER';
     case INFO = 'INFO';
     case GOOD = 'GOOD';

    public function getLabel(): string {
        return match($this){
            self::INFO => 'INFO',
            self::DANGER => 'DANGER',
            self::GOOD => 'GOOD',
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