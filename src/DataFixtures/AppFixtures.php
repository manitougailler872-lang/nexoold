<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

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
