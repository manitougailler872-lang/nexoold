<?php

namespace App\Service\Exchange\Provider;

use Psr\Cache\CacheItemPoolInterface;

final class CachedRateProvider implements IExchangeRateProvider
{
    public function __construct(
        private readonly IExchangeRateProvider $provider,
        private readonly CacheItemPoolInterface $cache,
    ) {
    }

    public function getRate(
        string $from,
        string $to,
        ?\DateTimeImmutable $date = null,
    ): float {
        $from = strtoupper($from);
        $to = strtoupper($to);

        if ($from === $to) {
            return 1.0;
        }

        $dateKey = $date?->format('Y-m-d') ?? 'latest';

        $cacheKey = sprintf(
            'exchange_rate_%s_%s_%s',
            $from,
            $to,
            $dateKey
        );

        $item = $this->cache->getItem($cacheKey);

        if ($item->isHit()) {
            return (float) $item->get();
        }

        $rate = $this->provider->getRate(
            $from,
            $to,
            $date
        );

        $item->set($rate);

        // Taux courant
        if ($date === null) {
            $item->expiresAfter(3600);
        } else {
            // Un taux historique ne changera plus
            $item->expiresAfter(86400 * 30);
        }

        $this->cache->save($item);

        return $rate;
    }
}