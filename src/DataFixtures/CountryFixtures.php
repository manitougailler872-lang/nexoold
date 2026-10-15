<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $countries = [
                [
                    'label' => 'France',
                    'codeIso2' => 'FR',
                    'codeIso3' => 'FRA',
                    'countryCode' => '+33',
                    'language' => 'fr_FR',
                    'currencyIso' => 'EUR',
                    'timeZone' => 'Europe/Paris',
                    'continent' => 'Europe',
                    'flag' => '🇫🇷',
                ],
                [
                    'label' => 'Belgique',
                    'codeIso2' => 'BE',
                    'codeIso3' => 'BEL',
                    'countryCode' => '+32',
                    'language' => 'fr_BE',
                    'currencyIso' => 'EUR',
                    'timeZone' => 'Europe/Brussels',
                    'continent' => 'Europe',
                    'flag' => '🇧🇪',
                ],
                [
                    'label' => 'Allemagne',
                    'codeIso2' => 'DE',
                    'codeIso3' => 'DEU',
                    'countryCode' => '+49',
                    'language' => 'de_DE',
                    'currencyIso' => 'EUR',
                    'timeZone' => 'Europe/Berlin',
                    'continent' => 'Europe',
                    'flag' => '🇩🇪',
                ],
                [
                    'label' => 'Espagne',
                    'codeIso2' => 'ES',
                    'codeIso3' => 'ESP',
                    'countryCode' => '+34',
                    'language' => 'es_ES',
                    'currencyIso' => 'EUR',
                    'timeZone' => 'Europe/Madrid',
                    'continent' => 'Europe',
                    'flag' => '🇪🇸',
                ],
                [
                    'label' => 'Italie',
                    'codeIso2' => 'IT',
                    'codeIso3' => 'ITA',
                    'countryCode' => '+39',
                    'language' => 'it_IT',
                    'currencyIso' => 'EUR',
                    'timeZone' => 'Europe/Rome',
                    'continent' => 'Europe',
                    'flag' => '🇮🇹',
                ],
                [
                    'label' => 'Suisse',
                    'codeIso2' => 'CH',
                    'codeIso3' => 'CHE',
                    'countryCode' => '+41',
                    'language' => 'de_CH',
                    'currencyIso' => 'CHF',
                    'timeZone' => 'Europe/Zurich',
                    'continent' => 'Europe',
                    'flag' => '🇨🇭',
                ],
                [
                    'label' => 'Luxembourg',
                    'codeIso2' => 'LU',
                    'codeIso3' => 'LUX',
                    'countryCode' => '+352',
                    'language' => 'fr_LU',
                    'currencyIso' => 'EUR',
                    'timeZone' => 'Europe/Luxembourg',
                    'continent' => 'Europe',
                    'flag' => '🇱🇺',
                ],
                [
                    'label' => 'Pologne',
                    'codeIso2' => 'PL',
                    'codeIso3' => 'POL',
                    'countryCode' => '+48',
                    'language' => 'pl_PL',
                    'currencyIso' => 'PLN',
                    'timeZone' => 'Europe/Warsaw',
                    'continent' => 'Europe',
                    'flag' => '🇵🇱',
                ],
                 [
                    'label' => 'Pays-Bas',
                    'codeIso2' => 'NL',
                    'codeIso3' => 'NLD',
                    'countryCode' => '+31',
                    'language' => 'nl_NL',
                    'currencyIso' => 'EUR',
                    'timeZone' => 'Europe/Amsterdam',
                    'continent' => 'Europe',
                    'flag' => '🇳🇱',
                ],
                [
                    'label' => 'Finlande',
                    'codeIso2' => 'FI',
                    'codeIso3' => 'FIN',
                    'countryCode' => '+358',
                    'language' => 'fi_FI',
                    'currencyIso' => 'EUR',
                    'timeZone' => 'Europe/Helsinki',
                    'continent' => 'Europe',
                    'flag' => '🇫🇮',
                ],
                [
                    'label' => 'Suède',
                    'codeIso2' => 'SE',
                    'codeIso3' => 'SWE',
                    'countryCode' => '+46',
                    'language' => 'sv_SE',
                    'currencyIso' => 'SEK',
                    'timeZone' => 'Europe/Stockholm',
                    'continent' => 'Europe',
                    'flag' => '🇸🇪',
                ],
                 [
                    'label' => 'Lettonie',
                    'codeIso2' => 'LV',
                    'codeIso3' => 'LVA',
                    'countryCode' => '+371',
                    'language' => 'lv_LV',
                    'currencyIso' => 'EUR',
                    'timeZone' => 'Europe/Riga',
                    'continent' => 'Europe',
                    'flag' => '🇱🇻',
                ],
                [
                    'label' => 'Lituanie',
                    'codeIso2' => 'LT',
                    'codeIso3' => 'LTU',
                    'countryCode' => '+370',
                    'language' => 'lt_LT',
                    'currencyIso' => 'EUR',
                    'timeZone' => 'Europe/Vilnius',
                    'continent' => 'Europe',
                    'flag' => '🇱🇹',
                ],
                [
                    'label' => 'Estonie',
                    'codeIso2' => 'EE',
                    'codeIso3' => 'EST',
                    'countryCode' => '+372',
                    'language' => 'et_EE',
                    'currencyIso' => 'EUR',
                    'timeZone' => 'Europe/Tallinn',
                    'continent' => 'Europe',
                    'flag' => '🇪🇪',
    ],
                [
                    'label' => 'Royaume-Uni',
                    'codeIso2' => 'GB',
                    'codeIso3' => 'GBR',
                    'countryCode' => '+44',
                    'language' => 'en_GB',
                    'currencyIso' => 'GBP',
                    'timeZone' => 'Europe/London',
                    'continent' => 'Europe',
                    'flag' => '🇬🇧',
                ],
                [
                    'label' => 'Chypre',
                    'codeIso2' => 'CY',
                    'codeIso3' => 'CYP',
                    'countryCode' => '+357',
                    'language' => 'el_CY',
                    'currencyIso' => 'EUR',
                    'timeZone' => 'Asia/Nicosia',
                    'continent' => 'Europe',
                    'flag' => '🇨🇾',
                ],
                // États-Unis
                [
                    'label' => 'États-Unis',
                    'codeIso2' => 'US',
                    'codeIso3' => 'USA',
                    'countryCode' => '+1',
                    'language' => 'en_US',
                    'currencyIso' => 'USD',
                    'timeZone' => 'America/New_York',
                    'continent' => 'Amérique du Nord',
                    'flag' => '🇺🇸',
                ],

                // Canada
                [
                    'label' => 'Canada',
                    'codeIso2' => 'CA',
                    'codeIso3' => 'CAN',
                    'countryCode' => '+1',
                    'language' => 'en_CA',
                    'currencyIso' => 'CAD',
                    'timeZone' => 'America/Toronto',
                    'continent' => 'Amérique du Nord',
                    'flag' => '🇨🇦',
                ],
               
            ];

            foreach ($countries as $item) {
                $country = new Country();
                $country
                    ->setLabel($item['label'])
                    ->setCodeIso3($item['codeIso3'])
                    ->setCodeIso2($item['codeIso2'])
                    ->setTimeZone($item['timeZone'])
                    ->setContinent($item['continent'])
                    ->setCountryCode($item['countryCode'])
                    ->setFlag($item['flag'])
                    ->setLanguage($item['language']);
                $manager->persist($country);
            }
            $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
           
        ];
    }
}