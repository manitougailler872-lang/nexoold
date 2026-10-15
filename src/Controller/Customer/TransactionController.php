<?php

namespace App\Controller\Customer;

use App\Entity\User;
use App\Utils\Common;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/customer')]
final class TransactionController extends AbstractController
{
    private const PER_PAGE = 6;
    
    #[Route('/transactions',  name: 'app_customer_transactions')]
    public function transactions(Request $request): Response
    {
        $sort = $request->query->getString('sort', 'desc');
        $sort = \in_array($sort, ['asc', 'desc'], true) ? $sort : 'desc';

        $all = Common::buildTransactionDataset();

        usort($all, static fn (array $a, array $b): int => 'asc' === $sort
            ? $a['date'] <=> $b['date']
            : $b['date'] <=> $a['date']);

        $connectedUser = $this->getUser();
        if(!$connectedUser instanceof User){
            return $this->redirectToRoute('app_logout');
        }
        $principalAccount = $connectedUser->getCustomer()->getAccounts()->filter( fn ($account) => $account->getPrincipal())[0];
        if(empty($principalAccount)){
            return $this->redirectToRoute('app_logout');
        }
        
        $range = (int) $request->query->get('range', 30);
        $range = \in_array($range, [7, 30, 90, 365], true) ? $range : 30;
        $customer = $connectedUser->getCustomer();

         $transactions = [];
        foreach($customer->getTransactions() as $transaction){
                $transactions[] =[
                    'date' => $transaction->getTransDate(),
                    'devise' => $transaction->getDevise()->getSymbol(),
                    'description' => $transaction->getDescription(),
                    'reference' => $transaction->getReference(),
                    'label' => $transaction->getTransType()->getLabel(),
                    'bgColor' => $transaction->getTransType()->getBgIconColor(),
                    'textColor' => $transaction->getTransType()->getTextIconColor(),
                    'category' => $transaction->getCategory()->getLabel(),
                    'iconSvg' => $transaction->getTransType()->getIconSvg(),
                    'operation' => $transaction->getOperation()->getLabel(),
                    'amount' => $transaction->getAmount(),
                    'status' => $transaction->getStatus()->label(),
                ];
        }
        $total = \count($transactions);
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));

        $page = $request->query->getInt('page', 1);
        $page = max(1, min($page, $totalPages));

        $offset = ($page - 1) * self::PER_PAGE;
        $slice = \array_slice($transactions, $offset, self::PER_PAGE);

        return $this->render('customer/transactions.html.twig', [
            'transactions' => $slice,
            'sortDirection' => $sort,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalItems' => $total,
            'rangeStart' => $total > 0 ? $offset + 1 : 0,
            'rangeEnd' => min($offset + self::PER_PAGE, $total),
            'filters' => ['sort' => $sort],
        ]);
    }

    #[Route('/transactions/export', name: 'app_customer_transactions_export', methods: ['GET'])]
    public function export(): Response
    {
        // TODO : générer un CSV depuis le repository, en streaming
        // (StreamedResponse) pour ne pas charger tout l'historique en mémoire.
        $this->addFlash('info', "L'export sera disponible prochainement.");
        return $this->redirectToRoute('app_transactions');
    }
}