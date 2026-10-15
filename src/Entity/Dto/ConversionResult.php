<?php

namespace App\Entity\Dto;

final readonly class ConversionResult
{
    public function __construct(
        public float $amount,
        public string $fromCurrency,
        public string $toCurrency,
        public float $rate,
        public float $convertedAmount,
        public \DateTimeImmutable $rateDate,
    ) {
    }
}