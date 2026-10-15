<?php

namespace App\Controller\Customer;

use App\Entity\User;
use App\Utils\Common;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/customer')]
final class DashboardController extends AbstractController
{
    #[Route('/dashboard',  name: 'app_customer_dashboard')]
    public function dashboard(Request $request): Response
    {
        $connectedUser = $this->getUser();
        if(!$connectedUser instanceof User){
            return $this->redirectToRoute('app_logout');
        }
        $principalAccount = $connectedUser->getCustomer()->getAccounts()->filter( fn ($account) => $account->getPrincipal())[0];
        if(empty($principalAccount)){
            return $this->redirectToRoute('app_logout');
        }
        $card = $connectedUser->getCustomer()->getCards()->filter( fn ($card) => $card->getIsPrincipal())[0];
        if(empty($card)){
            return $this->redirectToRoute('app_logout');
        }   
        $cardItem =  [
                'id' => 1,
                'brand' => 'visa',
                'variant' => $card->getVariante(),
                'first4' =>  substr($card->getCardNumber(),0,4),
                'last4' => substr($card->getCardNumber(),-4),
                'type' => 'Débit',
                'tier' => $card->getCardType()->getLabel(),
                'availableBalance' => $card->getAmount(),
                'limitUsedPercent' => $card->getPercentUsed(),
                'gaugeColor' => $card->getGaugeColor(),
                'expiry' => $card->getExpire(),
                'locked' => false,
            ];
        
        
        $range = (int) $request->query->get('range', 30);
        $range = \in_array($range, [7, 30, 90, 365], true) ? $range : 30;
        $customer = $connectedUser->getCustomer();
        $filteredData = $customer->getTransactions()->toArray();
        usort(
            $filteredData,
            fn($a, $b) => $b->getTransDate() <=> $a->getTransDate()
        );
        $transactions = [];
        foreach($filteredData as $transaction){
                $transactions[] =[
                    'date' => $transaction->getTransDate(),
                    'devise' => $transaction->getDevise()->getSymbol(),
                    'description' => $transaction->getDescription(),
                    'reference' => $transaction->getReference(),
                    'label' => $transaction->getTransType()->getLabel(),
                    'bgColor' => $transaction->getTransType()->getBgIconColor(),
                    'textColor' => $transaction->getTransType()->getTextIconColor(),
                    'category' => $transaction->getCategory()?->getLabel(),
                    'iconSvg' => $transaction->getTransType()->getIconSvg(),
                    'operation' => $transaction->getOperation()->getLabel(),
                    'amount' => $transaction->getAmount(),
                    'status' => $transaction->getStatus()->label(),
                ];
        }

        return $this->render('customer/dashboard.html.twig', [
             // --- Soldes ---
            'totalBalance' => $principalAccount->getAmount(),
            'accountsBalance' =>  $principalAccount->getAmount(),
            'cardsBalance' => 18230.20,
            'activeCards' => count($customer->getCards()),
            'monthlyChange' => 4.32,
            'principalAccount' => $principalAccount,
            'card' => $cardItem,
            'externalAccounts' => $customer->getExternalAccounts(),
            // --- Graphique d'évolution ---
            'selectedRange' => (string) $range,
            'balanceSeries' => Common::buildBalanceSeries($range),
            'transactions' => $transactions,
            // --- Répartition des avoirs (donut) ---
            'allocation' => [
                ['label' => 'Comptes',  'amount' => 112650.30, 'share' => 71.9, 'color' => '#0F7B3D'],
                ['label' => 'Cartes',    'amount' => 18230.20,  'share' => 11.6, 'color' => '#F0B429'],
                ['label' => 'Investissements','amount' => 26900.00,  'share' => 17.1, 'color' => '#3B82F6'],
                ['label' => 'Crypto-actifs',  'amount' => 1000.00,   'share' => 0.9,  'color' => '#8B5CF6'],
                ['label' => 'Autres',     'amount' => 0.00,      'share' => 0.0,  'color' => '#9CA3AF'],
            ],
            // --- Transactions ---
            // --- Notifications --
            // --- Indicateurs de bas de page ---
            'monthlySpending' => 4295.20,
            'spendingChange' => -8.2,
            'budgetRemaining' => 1704.80,
            'budgetTotal' => 6000.00,
            'savingsCurrent' => 15000.00,
            'savingsTarget' => 20000.00,
            'exchangeRate' => 1.0812,
            'exchangeRateDate' => new \DateTimeImmutable('2025-05-16 08:42'),
         ]);
    }
}