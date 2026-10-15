<?php

namespace App\Service\Exchange\Provider;

interface IExchangeRateProvider
{
    /**
     * Retourne le taux :
     *
     * 1 FROM = X TO
     *
     * Exemple :
     * EUR -> USD = 1.17
     */
    public function getRate(
        string $from,
        string $to,
        ?\DateTimeImmutable $date = null,
    ): float;
}