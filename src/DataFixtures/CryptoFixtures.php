<?php

namespace App\DataFixtures;

use App\Entity\CryptoType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CryptoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cryptos =  [
                [
                    'label' => 'BTC',
                    'name' => 'Bitcoin',
                    'icon' => 'bitcoin.jpg',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'ETH',
                    'name' => 'Ethereum',
                    'icon' => 'ethereum.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'USDT',
                    'name' => 'Tether',
                    'icon' => 'usdt.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'XRP',
                    'name' => 'XRP',
                    'icon' => 'xrp.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'USDC',
                    'name' => 'USD Coin',
                    'icon' => 'usdc.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'BNB',
                    'name' => 'BNB',
                    'icon' => 'bnb.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'SOL',
                    'name' => 'Solana',
                    'icon' => 'solana.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'ADA',
                    'name' => 'Cardano',
                    'icon' => 'ada.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'DOGE',
                    'name' => 'Dogecoin',
                    'icon' => 'doge.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'DOT',
                    'name' => 'Polkadot',
                    'icon' => 'polkadot.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'LTC',
                    'name' => 'Litecoin',
                    'icon' => 'litecoin.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'AVAX',
                    'name' => 'Avalanche',
                    'icon' => 'avalanche.svg',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'LINK',
                    'name' => 'Chainlink',
                    'icon' => 'chainlink.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'TRX',
                    'name' => 'TRON',
                    'icon' => 'tron.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'XLM',
                    'name' => 'Stellar',
                    'icon' => 'stella.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'SHIB',
                    'name' => 'Shiba Inu',
                    'icon' => 'shibainu.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'BCH',
                    'name' => 'Bitcoin Cash',
                    'icon' => 'bitcoin-cash.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'DAI',
                    'name' => 'Dai',
                    'icon' => 'dai.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'TON',
                    'name' => 'Toncoin',
                    'icon' => 'toncoin.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
                [
                    'label' => 'UNI',
                    'name' => 'Uniswap',
                    'icon' => 'uniswap.png',
                    'active' => true,
                    'createdAt' => new \DateTimeImmutable(),
                ],
            ];

            foreach ($cryptos as $crypto) {
                $cryptoItem = new CryptoType();
                $cryptoItem
                    ->setLabel($crypto['label'])
                    ->setTag($crypto['name'])
                    ->setIcon($crypto['icon'])
                    ->setActive(true);
                $manager->persist($cryptoItem);
            }
            $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
           
        ];
    }
}