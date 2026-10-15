<?php
declare(strict_types=1);
namespace App\Enum;

enum OperationTypeEnum: string
{
    case DEBIT = 'DEBIT';
    case CREDIT = 'CREDIT';

    public function getLabel() : string {
        return match($this){
            self::DEBIT => 'Débit',
            self::CREDIT => 'Crédit'
        };
    }

     public static function getLabel2(string $label) : OperationTypeEnum {
        return match($label){
            self::DEBIT => OperationTypeEnum::DEBIT,
            self::CREDIT => OperationTypeEnum::CREDIT
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