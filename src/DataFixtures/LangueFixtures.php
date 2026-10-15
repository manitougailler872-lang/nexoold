<?php

namespace App\DataFixtures;

use App\Entity\Langue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LangueFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $languages = [
            ['label' => 'Français', 'codeIso' => 'fr_FR', 'active' => true],
            ['label' => 'Anglais (États-Unis)', 'codeIso' => 'en_US', 'active' => true],
            ['label' => 'Anglais (Royaume-Uni)', 'codeIso' => 'en_GB', 'active' => true],
            ['label' => 'Allemand', 'codeIso' => 'de_DE', 'active' => true],
            ['label' => 'Espagnol', 'codeIso' => 'es_ES', 'active' => true],
            ['label' => 'Italien', 'codeIso' => 'it_IT', 'active' => true],
            ['label' => 'Portugais', 'codeIso' => 'pt_PT', 'active' => true],
            ['label' => 'Portugais (Brésil)', 'codeIso' => 'pt_BR', 'active' => true],
            ['label' => 'Néerlandais', 'codeIso' => 'nl_NL', 'active' => true],
            ['label' => 'Polonais', 'codeIso' => 'pl_PL', 'active' => true],
            ['label' => 'Roumain', 'codeIso' => 'ro_RO', 'active' => true],
            ['label' => 'Grec', 'codeIso' => 'el_GR', 'active' => true],
            ['label' => 'Tchèque', 'codeIso' => 'cs_CZ', 'active' => true],
            ['label' => 'Slovaque', 'codeIso' => 'sk_SK', 'active' => true],
            ['label' => 'Hongrois', 'codeIso' => 'hu_HU', 'active' => true],
            ['label' => 'Bulgare', 'codeIso' => 'bg_BG', 'active' => true],
            ['label' => 'Croate', 'codeIso' => 'hr_HR', 'active' => true],
            ['label' => 'Slovène', 'codeIso' => 'sl_SI', 'active' => true],
            ['label' => 'Serbe', 'codeIso' => 'sr_RS', 'active' => true],
            ['label' => 'Bosnien', 'codeIso' => 'bs_BA', 'active' => true],
            ['label' => 'Albanais', 'codeIso' => 'sq_AL', 'active' => true],
            ['label' => 'Macédonien', 'codeIso' => 'mk_MK', 'active' => true],
            ['label' => 'Danois', 'codeIso' => 'da_DK', 'active' => true],
            ['label' => 'Suédois', 'codeIso' => 'sv_SE', 'active' => true],
            ['label' => 'Norvégien', 'codeIso' => 'nb_NO', 'active' => true],
            ['label' => 'Finnois', 'codeIso' => 'fi_FI', 'active' => true],
            ['label' => 'Islandais', 'codeIso' => 'is_IS', 'active' => true],
            ['label' => 'Irlandais', 'codeIso' => 'ga_IE', 'active' => true],
            ['label' => 'Estonien', 'codeIso' => 'et_EE', 'active' => true],
            ['label' => 'Letton', 'codeIso' => 'lv_LV', 'active' => true],
            ['label' => 'Lituanien', 'codeIso' => 'lt_LT', 'active' => true],
            ['label' => 'Ukrainien', 'codeIso' => 'uk_UA', 'active' => true],
            ['label' => 'Russe', 'codeIso' => 'ru_RU', 'active' => true],
            ['label' => 'Biélorusse', 'codeIso' => 'be_BY', 'active' => true],
            ['label' => 'Turc', 'codeIso' => 'tr_TR', 'active' => true],

            ['label' => 'Arabe', 'codeIso' => 'ar_SA', 'active' => true],
            ['label' => 'Hébreu', 'codeIso' => 'he_IL', 'active' => true],
            ['label' => 'Persan', 'codeIso' => 'fa_IR', 'active' => true],

            ['label' => 'Chinois simplifié', 'codeIso' => 'zh_CN', 'active' => true],
            ['label' => 'Chinois traditionnel', 'codeIso' => 'zh_TW', 'active' => true],
            ['label' => 'Japonais', 'codeIso' => 'ja_JP', 'active' => true],
            ['label' => 'Coréen', 'codeIso' => 'ko_KR', 'active' => true],

            ['label' => 'Hindi', 'codeIso' => 'hi_IN', 'active' => true],
            ['label' => 'Bengali', 'codeIso' => 'bn_BD', 'active' => true],
            ['label' => 'Ourdou', 'codeIso' => 'ur_PK', 'active' => true],
            ['label' => 'Pendjabi', 'codeIso' => 'pa_IN', 'active' => true],
            ['label' => 'Tamoul', 'codeIso' => 'ta_IN', 'active' => true],
            ['label' => 'Télougou', 'codeIso' => 'te_IN', 'active' => true],
            ['label' => 'Marathi', 'codeIso' => 'mr_IN', 'active' => true],
            ['label' => 'Gujarati', 'codeIso' => 'gu_IN', 'active' => true],
            ['label' => 'Népalais', 'codeIso' => 'ne_NP', 'active' => true],

            ['label' => 'Indonésien', 'codeIso' => 'id_ID', 'active' => true],
            ['label' => 'Malais', 'codeIso' => 'ms_MY', 'active' => true],
            ['label' => 'Vietnamien', 'codeIso' => 'vi_VN', 'active' => true],
            ['label' => 'Thaï', 'codeIso' => 'th_TH', 'active' => true],
            ['label' => 'Philippin', 'codeIso' => 'fil_PH', 'active' => true],

            ['label' => 'Swahili', 'codeIso' => 'sw_KE', 'active' => true],
            ['label' => 'Afrikaans', 'codeIso' => 'af_ZA', 'active' => true],
            ['label' => 'Amharique', 'codeIso' => 'am_ET', 'active' => true],
            ['label' => 'Somali', 'codeIso' => 'so_SO', 'active' => true],
            ['label' => 'Haoussa', 'codeIso' => 'ha_NG', 'active' => true],
            ['label' => 'Yoruba', 'codeIso' => 'yo_NG', 'active' => true],
            ['label' => 'Igbo', 'codeIso' => 'ig_NG', 'active' => true],

            ['label' => 'Catalan', 'codeIso' => 'ca_ES', 'active' => true],
            ['label' => 'Basque', 'codeIso' => 'eu_ES', 'active' => true],
            ['label' => 'Galicien', 'codeIso' => 'gl_ES', 'active' => true],

            ['label' => 'Arménien', 'codeIso' => 'hy_AM', 'active' => true],
            ['label' => 'Géorgien', 'codeIso' => 'ka_GE', 'active' => true],
            ['label' => 'Azéri', 'codeIso' => 'az_AZ', 'active' => true],
            ['label' => 'Kazakh', 'codeIso' => 'kk_KZ', 'active' => true],
            ['label' => 'Ouzbek', 'codeIso' => 'uz_UZ', 'active' => true],
            ['label' => 'Mongol', 'codeIso' => 'mn_MN', 'active' => true],

            ['label' => 'Créole haïtien', 'codeIso' => 'ht_HT', 'active' => true],
        ];
        foreach ($languages as $item) {
            $devise = new Langue();
            $devise
                ->setLabel($item['label'])
                ->setCodeIso($item['codeIso'])
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