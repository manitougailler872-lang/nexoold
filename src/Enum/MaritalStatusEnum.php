<?php
declare(strict_types=1);
namespace App\Enum;

enum MaritalStatusEnum: string
{
  case SINGLE = 'SINGLE';
  case MARRIED = 'MARRIED';
  case DIVORCED = 'DIVORCED';
  case WIDOW = 'WIDOW';


  public function getLabel():string {
    return match($this){
        self::DIVORCED => 'Divorcé',
        self::MARRIED => 'Marié',
        self::WIDOW => 'Veuf(ve)',
        self::SINGLE => 'Célibataire'
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