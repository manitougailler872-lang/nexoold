<?php

namespace App\Service\Exchange\Provider;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ExchangeRateProvider implements IExchangeRateProvider
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
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

        $datePath = $date?->format('Y-m-d') ?? 'latest';

        $response = $this->httpClient->request(
            'GET',
            sprintf(
                'https://api.frankfurter.app/%s',
                $datePath
            ),
            [
                'query' => [
                    'from' => $from,
                    'to' => $to,
                ],
                'timeout' => 10,
            ]
        );

        $data = $response->toArray();

        $rate = $data['rates'][$to] ?? null;

        if ($rate === null) {
            throw new \RuntimeException(
                sprintf(
                    'Impossible de récupérer le taux %s/%s.',
                    $from,
                    $to
                )
            );
        }

        return (float) $rate;
    }
}