<?php

declare(strict_types=1);

namespace App\Service\Sms\Exception;

final class SmsSendingFailedException extends SmsException
{
    public static function afterRetries(string $to, int $attempts, \Throwable $previous): self
    {
        return new self(
            sprintf('Échec de l\'envoi du SMS vers "%s" après %d tentative(s) : %s', $to, $attempts, $previous->getMessage()),
            previous: $previous,
        );
    }
}
