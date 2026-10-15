<?php

namespace App\Twig;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\Extension\AbstractExtension;
use App\Service\Exchange\CurrencyConverter;
use Twig\TwigFunction;
use Twig\TwigFilter;

final class NexoTradeExtension extends AbstractExtension
{
    public function __construct(private readonly Security $security,
    private readonly CurrencyConverter $converter)
    { }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('nexo_header_data', [$this, 'getHeaderData']),
            new TwigFunction('generate_color', [$this, 'generateColor']),
            new TwigFunction('day_period', [$this, 'getDayPeriod']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter(
                'convert_currency',
                [$this, 'convert']
            ),
        ];
    }

    public function convert(
        float $amount,
        string $from,
        string $to,
    ): float {
        return $this->converter
            ->convert($amount, $from, $to)
            ->convertedAmount;
    }

    public function getDayPeriod(?\DateTimeInterface $date = null): string
    {
        $date ??= new \DateTimeImmutable();

        $hour = (int) $date->format('H');

        return match (true) {
            $hour >= 5 && $hour < 12  => 'morning',
            $hour >= 12 && $hour < 18 => 'afternoon',
            $hour >= 18 && $hour < 23 => 'evening',
            default                   => 'night',
        };
    }

    public function generateColor(): string
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    public function getHeaderData(): array
    {
        $connectedUser = $this->security->getUser();
        if(!$connectedUser instanceof User){
            return [];
        }
        $customer = $connectedUser->getCustomer();
        $unreadAlerts = $connectedUser->getCustomer()->getAlerts()->filter(fn($alert) => !$alert->getRead())->count();
        $unreadMessages = $connectedUser->getCustomer()->getMessages()->filter(fn($message) => !$message->getRead())->count();
        $principalAccount = $connectedUser->getCustomer()->getAccounts()->filter( fn ($account) => $account->getPrincipal())[0];
        $messages = $alerts =  [];
        foreach($customer->getMessages() as $message){
            $messages[] = [
                'sender' => $message->getTitle(),
                'initials' => strtoupper(substr($message->getLabel(),0,2)),
                'subject' => $message->getSubTitle(),
                'excerpt' => $message->getDescription(),
                'date' =>  $message->getDate(),
                'read' => $message->getRead(),
            ];
        }
        foreach($customer->getAlerts() as $alert){
            $alerts[] =  [
                    'type' => 'security',
                    'title' =>$alert->getLabel(),
                    'subtitle' =>$alert->getSubTitle(),
                    'amount' => $alert?->getAmount(),
                    'date' => $alert->getDate(),
                    'read' =>  $alert->getRead(),
                ];
        }
        return [

            // --- Identité affichée dans la barre supérieure ---
            'fullName' => $connectedUser->getFullname(),
            'email' => $connectedUser->getCustomer()->getEmail(),
            'reference' => $connectedUser->getCustomer()->getReference(),
            'initials' =>  $connectedUser->getInitials(),
            'accountLabel' => $principalAccount->getLabel(),
            'currency' => $principalAccount->getDevise()->getCodeIso(),
            'lastConnection' => $connectedUser->getLastLoginAt(),
            'unreadMessages' => $unreadMessages,
            'unreadNotifications' => $unreadAlerts,

            // --- Messagerie (panneau de la barre supérieure) ---
            'userEmail' => $customer->getEmail(),
            'accountNumber' => $customer->getPhoneNumber(),
            'messages' => $messages,
            'notifications' => $alerts
        ];
    }
}