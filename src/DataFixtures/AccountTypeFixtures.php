<?php

namespace App\DataFixtures;

use App\Entity\AccountType;
use App\Enum\AccountTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AccountTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $accountTypes = [
            [
                'label' => 'Compte Nexo',
                'description' => 'Le compte principal NexoTrade pour gérer les opérations bancaires du quotidien, recevoir des fonds, effectuer des virements et utiliser une carte bancaire.',
                'advantages' => 'Compte principal NexoTrade|Virements bancaires|Carte bancaire|Paiements en ligne et en magasin|Suivi des transactions en temps réel|Gestion depuis l’espace client',
                'plafond' => '50000.00',
                'currencyIso' => 'EUR',
                'tag' => AccountTypeEnum::NEXO
            ],
            [
                'label' => 'Compte Épargne+',
                'description' => 'Un compte destiné à mettre de l’argent de côté et à séparer son épargne des dépenses courantes.',
                'advantages' => 'Épargne séparée du compte principal|Versements libres|Suivi du montant épargné|Transferts avec le compte principal|Consultation depuis l’espace NexoTrade',
                'plafond' => '100000.00',
                'currencyIso' => 'EUR',
                'tag' => AccountTypeEnum::EPARGNE_NEXO
            ],
            [
                'label' => 'Compte Nexo Pro',
                'description' => 'Le compte NexoTrade destiné aux professionnels pour gérer leurs encaissements, dépenses et opérations liées à leur activité.',
                'advantages' => 'Compte dédié à l’activité professionnelle|Virements professionnels|Gestion des paiements|Suivi des entrées et sorties|Carte bancaire professionnelle|Historique des transactions',
                'plafond' => '250000.00',
                'currencyIso' => 'EUR',
                'tag' => AccountTypeEnum::NEXO_PRO
            ],
        ];

        foreach($accountTypes as $type){

                $item = new AccountType();
                
                $item->setLabel($type['label'])
                ->setDescription($type['description'])
                ->setAdvantages($type['advantages'])
                ->setPlafond($type['plafond'])
                ->setDevise($type['currencyIso'])
                ->setTag($type['tag']->value);

                $manager->persist($item);
        }
        $manager->flush();
    }

   public function getDependencies(): array
    {
        return [
                AccountTypeFixtures::class,
                BanqueFixtures::class,
                CardTypeFixtures::class,
                CountryFixtures::class,
                CryptoFixtures::class,
                DeviseFixtures::class,
                LangueFixtures::class,
                TypeTransactionFixtures::class
        ];
    }
}