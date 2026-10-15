<?php

namespace App\Controller\Customer;

use App\Entity\User;
use App\Utils\Common;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/customer')]
final class CardController extends AbstractController
{
    private const PER_PAGE = 6;

         /**
     *  ********************GESTION DES CARTES*******************
     * */
    #[Route('/cards',  name: 'app_customer_cards')]
    public function cards(): Response
    {
        $connectedUser = $this->getUser();
        if(!$connectedUser instanceof User){
            return $this->redirectToRoute('app_logout');
        }
        $cards = [];
        $i = 1;
        foreach($connectedUser->getCustomer()->getCards() as $card){
            $cards[] =  [
                'id' => $i,
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
        }
        return $this->render('customer/cards.html.twig', [
           
        // Indicateurs
            'activeCards' => 3,
            'totalCards' => 4,
            'monthlySpending' => 2450.80,
            'availableCredit' => 12750.20,
            'monthlyChange' => 8.2,
            'cards' => $cards,

            // Transactions par carte
            'cardTransactions' => [
                [
                    'cardLast4' => '4008',
                    'cardBrand' => 'visa',
                    'cardVariant' => 'emerald',
                    'date' => new \DateTimeImmutable('2025-05-16 14:32'),
                    'description' => 'Carrefour Market Paris',
                    'amount' => -78.50,
                    'status' => 'Débitée',
                ],
                [
                    'cardLast4' => '9464',
                    'cardBrand' => 'mastercard',
                    'cardVariant' => 'emerald-bright',
                    'date' => new \DateTimeImmutable('2025-05-16 11:05'),
                    'description' => 'Airbnb Ireland',
                    'amount' => -320.00,
                    'status' => 'Débitée',
                ],
                [
                    'cardLast4' => '6790',
                    'cardBrand' => 'visa',
                    'cardVariant' => 'emerald-deep',
                    'date' => new \DateTimeImmutable('2025-05-15 09:18'),
                    'description' => 'Amazon EU',
                    'amount' => -159.99,
                    'status' => 'Débitée',
                ],
            ],
            'hasMoreTransactions' => true,
        ]);
    }

    #[Route('/cartes/setting', name: 'app_cards_settings', methods: ['GET'])]
    public function cardSettings(): Response
    {
        return $this->render('customer/card_settingl.html.twig', [
            'pageTitle' => 'Paramètres des cartes',
        ]);
    }

    #[Route('/cartes/{id}', name: 'app_card_show', methods: ['GET'])]
    public function show(string $id): Response
    {
        return $this->render('customer/card_detail.html.twig', [
            'pageTitle' => 'Détail de la carte',
        ]);
    }

    /**
     * Blocage / déblocage d'une carte.
     *
     * En POST avec jeton CSRF : une action qui modifie l'état d'un moyen de
     * paiement ne doit jamais être déclenchable par un simple GET (un lien
     * préchargé par le navigateur suffirait à bloquer la carte du client).
     */
    #[Route('/cartes/{id}/blocage', name: 'app_card_lock', methods: ['POST'])]
    public function lock(Request $request, string $id): Response
    {
        if (!$this->isCsrfTokenValid('lock-card-'.$id, (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Requête invalide.');
            return $this->redirectToRoute('app_cards');
        }

        // TODO : basculer Card::status via CardRepository, journaliser l'action.
        $this->addFlash('success', 'Le statut de la carte a été mis à jour.');
        return $this->redirectToRoute('app_cards');
    }

    #[Route('/cartes/order', name: 'app_card_order', methods: ['GET'])]
    public function order(): Response
    {
        return $this->render('customer/card_order.html.twig', [
            'pageTitle' => 'Commander une carte',
        ]);
    }
    
}