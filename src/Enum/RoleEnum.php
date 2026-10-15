<?php
declare(strict_types=1);
namespace App\Enum;

enum RoleEnum: string
{
     case ROLE_USER = 'ROLE_USER';
     case ROLE_CUSTOMER = 'ROLE_CUSTOMER';
     case ROLE_ADMIN = 'ROLE_ADMIN';

     public function getLabel():string {
        return match($this){
            self::ROLE_USER => 'Utilisateur',
            self::ROLE_CUSTOMER => 'Client',
            self::ROLE_ADMIN =>'Administrateur'
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