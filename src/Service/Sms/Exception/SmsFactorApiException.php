<?php

declare(strict_types=1);

namespace App\Service\Sms\Exception;

/**
 * Enveloppe toute erreur retournée par l'API SMSFactor (status != 1).
 * Voir la liste des statuts sur https://dev.smsfactor.com/fr/api/sms/a-propos-du-sms
 */
final class SmsFactorApiException extends SmsException
{
    public function __construct(
        string $message,
        private readonly ?int $apiStatus = null,
        private readonly ?int $httpStatus = null,
    ) {
        //parent::__construct($message);
    }

    public static function fromResponse(string $message, ?int $apiStatus, ?int $httpStatus): self
    {
        return new self($message, $apiStatus, $httpStatus);
    }

    public function getApiStatus(): ?int
    {
        return $this->apiStatus;
    }

    public function getHttpStatus(): ?int
    {
        return $this->httpStatus;
    }
}
