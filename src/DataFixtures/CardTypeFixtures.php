<?php

namespace App\DataFixtures;

use App\Entity\CardType;
use App\Enum\CardTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CardTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cardTypes = [
              [
                'label' => 'Carte Nexo',
                'description' => 'Le carte principal NexoTrade pour gérer les opérations bancaires du quotidien, recevoir des fonds, effectuer des virements et utiliser une carte bancaire.',
                'advantages' => 'Card principal NexoTrade|Virements bancaires|Carte bancaire|Paiements en ligne et en magasin|Suivi des transactions en temps réel|Gestion depuis l’espace client',
                'tag' => CardTypeEnum::NEXO,
                'amount' => '50000.00',
                'spendByMonth' => '50000.00',
                'spendByDay' => '500.00',
                'currencyIso' => 'EUR',
            ],
            [
                'label' => 'Carte Premium',
                'description' => 'Une carte destiné à mettre de l’argent de côté et à séparer son épargne des dépenses courantes.',
                'advantages' => 'Épargne séparée du compte principal|Versements libres|Suivi du montant épargné|Transferts avec le compte principal|Consultation depuis l’espace NexoTrade',
                'tag' => CardTypeEnum::PRO,
                'amount' => '100000.00',
                'spendByMonth' => '80000.00',
                'spendByDay' => '2500.00',
                'currencyIso' => 'EUR',
            ],
            [
                'label' => 'Carte Elite',
                'description' => 'La carte NexoTrade destiné aux professionnels pour gérer leurs encaissements, dépenses et opérations liées à leur activité.',
                'advantages' => 'Carte dédié à l’activité professionnelle|Virements professionnels|Gestion des paiements|Suivi des entrées et sorties|Carte bancaire professionnelle|Historique des transactions',
                'tag' => CardTypeEnum::ELITE,
                'amount' => '200000.00',
                'spendByMonth' => '700000.00',
                'spendByDay' => '5000.00',
                'currencyIso' => 'EUR',
            ],
        ];
        foreach($cardTypes as $cardType){

                $item = new CardType();
                $item->setLabel($cardType['label'])
                ->setAmount(true)
                ->setDescription($cardType['description'])
                ->setAdvantages($cardType['advantages'])
                ->setTag($cardType['tag']->value)
                ->setSpendByDay($cardType['spendByDay'])
                ->setSpendByMonth($cardType['spendByMonth'])
               ->setDevise($cardType['currencyIso']);
               
                $manager->persist($item);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
           
        ];
    }
}