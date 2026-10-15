<?php

namespace App\Service\Exchange;

use App\Entity\Dto\ConversionResult;
use App\Service\Exchange\Provider\IExchangeRateProvider;

final class CurrencyConverter
{
    private const SUPPORTED_CURRENCIES = [
        'EUR',
        'USD',
        'GBP',
        'CAD',
        // Europe
        'PLN',
        'SEK',
        'CZK',
        'RON',
        // Suisse
        'CHF',
        // autres
        'JPY',
        'AUD',
        'NZD',
        'DKK',
        'NOK',
    ];

    public function __construct(
        //private readonly IExchangeRateProvider $rateProvider,
    ) {
    }

    // public function convert(
    //     float $amount,
    //     string $from,
    //     string $to,
    //     ?\DateTimeImmutable $date = null,
    // ): ConversionResult {
        
    //     $from = $this->normalizeCurrency($from);
    //     $to = $this->normalizeCurrency($to);

    //     $this->validateCurrency($from);
    //     $this->validateCurrency($to);

    //     if ($amount < 0) {
    //         throw new \InvalidArgumentException(
    //             'Le montant ne peut pas être négatif.'
    //         );
    //     }

    //     if ($from === $to) {
    //         return new ConversionResult(
    //             amount: $amount,
    //             fromCurrency: $from,
    //             toCurrency: $to,
    //             rate: 1,
    //             convertedAmount: $this->round($amount, $to),
    //             rateDate: $date ?? new \DateTimeImmutable(),
    //         );
    //     }

    //     $rate = $this->rateProvider->getRate(
    //         $from,
    //         $to,
    //         $date
    //     );

    //     $converted = $amount * $rate;

    //     return new ConversionResult(
    //         amount: $amount,
    //         fromCurrency: $from,
    //         toCurrency: $to,
    //         rate: $rate,
    //         convertedAmount: $this->round(
    //             $converted,
    //             $to
    //         ),
    //         rateDate: $date ?? new \DateTimeImmutable(),
    //     );
    // }

    // public function getRate(
    //     string $from,
    //     string $to,
    //     ?\DateTimeImmutable $date = null,
    // ): float {
    //     $from = $this->normalizeCurrency($from);
    //     $to = $this->normalizeCurrency($to);

    //     $this->validateCurrency($from);
    //     $this->validateCurrency($to);

    //     return $this->rateProvider->getRate(
    //         $from,
    //         $to,
    //         $date
    //     );
    // }

    // public function convertMany(
    //     float $amount,
    //     string $from,
    //     array $currencies,
    // ): array {
    //     $results = [];

    //     foreach ($currencies as $currency) {
    //         $results[$currency] = $this->convert(
    //             $amount,
    //             $from,
    //             $currency
    //         );
    //     }

    //     return $results;
    // }

    // public function isSupported(string $currency): bool
    // {
    //     return in_array(
    //         strtoupper($currency),
    //         self::SUPPORTED_CURRENCIES,
    //         true
    //     );
    // }

    // private function normalizeCurrency(string $currency): string
    // {
    //     return strtoupper(trim($currency));
    // }

    // private function validateCurrency(string $currency): void
    // {
    //     if (!$this->isSupported($currency)) {
    //         throw new \InvalidArgumentException(
    //             sprintf(
    //                 'La devise "%s" n\'est pas supportée.',
    //                 $currency
    //             )
    //         );
    //     }
    // }

    // private function round(
    //     float $amount,
    //     string $currency,
    // ): float {
    //     return round(
    //         $amount,
    //         $this->getCurrencyPrecision($currency),
    //         PHP_ROUND_HALF_UP
    //     );
    // }

    // private function getCurrencyPrecision(string $currency): int
    // {
    //     return match ($currency) {
    //         'JPY' => 0,

    //         default => 2,
    //     };
    // }
}