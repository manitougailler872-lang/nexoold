<?php

namespace App\Controller\Customer;

use App\Utils\Common;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/customer')]
final class VirementController extends AbstractController
{
    private const PER_PAGE = 6;

    #[Route('/send',  name: 'app_customer_send_money')]
    public function send(Request $request): Response
    {
         $accounts = [
            ['id' => 1, 'label' => 'Compte principal', 'last4' => '9012', 'currency' => 'EUR', 'balance' => 8925.40],
            ['id' => 2, 'label' => 'Compte Épargne+',  'last4' => '3210', 'currency' => 'EUR', 'balance' => 32230.30],
            ['id' => 3, 'label' => 'Compte NexoPro',   'last4' => '0112', 'currency' => 'EUR', 'balance' => 14999.99],
        ];

        return $this->render('customer/send.html.twig', [
            // Barre supérieure
            'fullName' => 'Barry Armstrong',
            'initials' => 'BA',
            'accountLabel' => 'Compte principal',
            'currency' => 'EUR',
            'unreadMessages' => 3,
            'unreadNotifications' => 6,
            'accounts' => $accounts,
            'debitAccount' => $accounts[0],
            'beneficiaries' => [
                ['id' => 1, 'name' => 'John Doe',                  'initials' => 'JD', 'iban' => 'FR85 3000 4008 2800 0100 1234 567'],
                ['id' => 2, 'name' => 'Marie Smith',               'initials' => 'MS', 'iban' => 'FR14 2004 1010 0505 0001 3M02 606'],
                ['id' => 3, 'name' => 'Lucas Bernard',             'initials' => 'LB', 'iban' => 'FR82 1027 8060 3400 0201 2340 123'],
                ['id' => 4, 'name' => 'Alexandre Dubois',          'initials' => 'AD', 'iban' => 'FR15 3000 6000 0112 3456 7890 123'],
                ['id' => 5, 'name' => 'Sophie Cartier',            'initials' => 'SC', 'iban' => 'FR59 1695 8000 0102 3456 7890 145'],
                ['id' => 6, 'name' => 'Entreprise Tech Solutions', 'initials' => 'ET', 'iban' => 'FR64 3000 2070 1200 0007 8945 612'],
            ],
            'prefill' => ['amount' => '', 'reason' => ''],
            // Contexte de l'assistant bénéficiaire inclus dans la page.
            'countries' => Common::countries(),
            'banks' => Common::banks(),
        ]);
    }

    #[Route('/virements/export', name: 'app_customer_send_export', methods: ['GET'])]
    public function sendExport(): Response
    {
        // TODO : CSV en streaming (StreamedResponse) sur la requête filtrée,
        // pour ne pas charger tout l'historique en mémoire.
        $this->addFlash('info', "L'export sera disponible prochainement.");
        return $this->redirectToRoute('app_transfers');
    }

    #[Route('/virements/{id}/justificatif', name: 'app_customer_send_quickly_receipt', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function receipt(int $id): Response
    {
        // TODO : vérifier que le virement appartient au client connecté
        // avant de servir le PDF.
        return $this->render('dashboard/_placeholder.html.twig', ['pageTitle' => 'Justificatif de virement']);
    }

}