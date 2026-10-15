<?php

namespace App\DataFixtures;

use App\Entity\Devise;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DeviseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $currencies = [
            [
                'countryIso' => 'FR',
                'label' => 'Euro',
                'codeIso' => 'EUR',
                'symbol' => '€',
                'active' => true,
            ],
            [
                'countryIso' => 'US',
                'label' => 'Dollar américain',
                'codeIso' => 'USD',
                'symbol' => '$',
                'active' => true,
            ],
            [
                'countryIso' => 'CA',
                'label' => 'Dollar canadien',
                'codeIso' => 'CAD',
                'symbol' => 'C$',
                'active' => true,
            ],
            [
                'countryIso' => 'GB',
                'label' => 'Livre sterling',
                'codeIso' => 'GBP',
                'symbol' => '£',
                'active' => true,
            ],
            [
                'countryIso' => 'CH',
                'label' => 'Franc suisse',
                'codeIso' => 'CHF',
                'symbol' => 'CHF',
                'active' => true,
            ],
            [
                'countryIso' => 'SE',
                'label' => 'Couronne suédoise',
                'codeIso' => 'SEK',
                'symbol' => 'kr',
                'active' => true,
            ],
            [
                'countryIso' => 'NO',
                'label' => 'Couronne norvégienne',
                'codeIso' => 'NOK',
                'symbol' => 'kr',
                'active' => true,
            ],
            [
                'countryIso' => 'DK',
                'label' => 'Couronne danoise',
                'codeIso' => 'DKK',
                'symbol' => 'kr',
                'active' => true,
            ],
            [
                'countryIso' => 'PL',
                'label' => 'Zloty polonais',
                'codeIso' => 'PLN',
                'symbol' => 'zł',
                'active' => true,
            ],
            [
                'countryIso' => 'CZ',
                'label' => 'Couronne tchèque',
                'codeIso' => 'CZK',
                'symbol' => 'Kč',
                'active' => true,
            ],
            [
                'countryIso' => 'RO',
                'label' => 'Leu roumain',
                'codeIso' => 'RON',
                'symbol' => 'lei',
                'active' => true,
            ],
        ];
        foreach ($currencies as $item) {
            $devise = new Devise();
            $devise
                ->setLabel($item['label'])
                ->setCodeIso($item['codeIso'])
                ->setSymbol($item['symbol'])
                ->setCountryIso($item['countryIso'])
                ->setActive($item['active']);

            $manager->persist($devise);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
           
        ];
    }
}