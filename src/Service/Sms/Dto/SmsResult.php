<?php

declare(strict_types=1);

namespace App\Service\Sms\Dto;

final class SmsResult
{
    public function __construct(
        public readonly bool $success,
        public readonly ?string $sid = null,
        public readonly ?string $status = null,
        public readonly ?string $to = null,
        public readonly ?string $from = null,
        public readonly ?float $price = null,
        public readonly ?string $priceUnit = null,
        public readonly ?string $errorCode = null,
        public readonly ?string $errorMessage = null,
        public readonly ?\DateTimeImmutable $dateCreated = null,
    ) {
    }

    public static function success(
        string $sid,
        string $status,
        string $to,
        string $from,
        ?float $price = null,
        ?string $priceUnit = null,
    ): self {
        return new self(
            success: true,
            sid: $sid,
            status: $status,
            to: $to,
            from: $from,
            price: $price,
            priceUnit: $priceUnit,
            dateCreated: new \DateTimeImmutable(),
        );
    }

    public static function failure(string $errorMessage, ?string $errorCode = null, ?string $to = null): self
    {
        return new self(
            success: false,
            to: $to,
            errorCode: $errorCode,
            errorMessage: $errorMessage,
        );
    }
}
