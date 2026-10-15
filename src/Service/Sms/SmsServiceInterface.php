<?php

declare(strict_types=1);

namespace App\Service\Sms;

use App\Service\Sms\Dto\SmsMessage;
use App\Service\Sms\Dto\SmsResult;

interface SmsServiceInterface
{
    /**
     * Envoie un SMS unique de façon synchrone.
     */
    public function send(SmsMessage $message): SmsResult;

    /**
     * Envoie plusieurs SMS. Ne s'arrête pas au premier échec.
     *
     * @param SmsMessage[] $messages
     *
     * @return SmsResult[] indexé dans le même ordre que $messages
     */
    public function sendBulk(array $messages): array;

    /**
     * Récupère le statut courant d'un SMS déjà envoyé (delivered, failed, undelivered...).
     */
    public function getStatus(string $sid): SmsResult;
}
