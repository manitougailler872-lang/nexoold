<?php

namespace App\Service\IPAddress;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IPAddress
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly HttpClientInterface $httpClient,
        private readonly string $ipApiKey
    ) {
    }

    public function getIp(): ?string
    {
        return $this->requestStack
            ->getCurrentRequest()
            ?->getClientIp();
    }

    public function getLocation(): array
    {
        $ip = $this->getIp();
        if (!$ip) {
            return $this->emptyResult();
        }

        // En environnement local
        // if ($this->isLocalIp($ip)) {
        //     return [
        //         'ip' => $ip,
        //         'country' => null,
        //         'country_code' => null,
        //         'region' => null,
        //         'city' => null,
        //         'timezone' => null,
        //         'latitude' => null,
        //         'longitude' => null,
        //         'is_local' => true,
        //     ];
        // }

        try {
            $response = $this->httpClient->request(
                'GET',
                sprintf('https://api.ipwho.org/ip/%s?%s', urlencode($ip), $this->ipApiKey),
                [
                    'timeout' => 3,
                ]
            );
            $data = $response->toArray(false);
            if (($data['success'] ?? true) === false) {
                return $this->emptyResult($ip);
            }

            return [
                'ip' => $ip,

                'country' => $data['country'] ?? null,

                'country_code' => $data['country_code'] ?? null,

                'region' => $data['region'] ?? null,

                'city' => $data['city'] ?? null,

                'timezone' => $data['timezone']['id'] ?? null,

                'latitude' => $data['latitude'] ?? null,

                'longitude' => $data['longitude'] ?? null,

                'isp' => $data['connection']['isp'] ?? null,

                'asn' => $data['connection']['asn'] ?? null,

                'is_local' => false,
            ];
        } catch (\Throwable) {
            return $this->emptyResult($ip);
        }
    }

    private function isLocalIp(string $ip): bool
    {
        return !filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );
    }

    private function emptyResult(?string $ip = null): array
    {
        return [
            'ip' => $ip,
            'country' => null,
            'country_code' => null,
            'region' => null,
            'city' => null,
            'timezone' => null,
            'latitude' => null,
            'longitude' => null,
            'isp' => null,
            'asn' => null,
            'is_local' => false,
        ];
    }
}