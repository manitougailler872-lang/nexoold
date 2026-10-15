<?php

namespace App\Controller\Customer;

use App\Utils\Common;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/customer')]
final class LoanController extends AbstractController
{
    private const PER_PAGE = 6;

    /** Taille maximale acceptée pour une signature manuscrite encodée en base64. */
    private const MAX_SIGNATURE_BYTES = 300 * 1024;
       
    #[Route('/prets/demandes', name: 'app_customer_loans', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $all = Common::buildLoanDataset();

        foreach ($all as $index => $loan) {
            $all[$index]['amortization'] = null !== $loan['monthlyPayment'] && null !== $loan['firstPaymentAt']
                ? Common::buildAmortization(
                    $loan['amount'],
                    $loan['durationMonths'],
                    $loan['monthlyPayment'],
                    (float) str_replace(',', '.', $loan['rate']),
                    $loan['firstPaymentAt']
                )
                : [];
        }

        $total = \count($all);
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));

        $page = $request->query->getInt('page', 1);
        $page = max(1, min($page, $totalPages));
        $offset = ($page - 1) * self::PER_PAGE;

        return $this->render('customer/loans.html.twig', [

            // Barre supérieure
            'fullName' => 'Barry Armstrong',
            'initials' => 'BA',
            'accountLabel' => 'Compte principal',
            'currency' => 'EUR',
            'unreadMessages' => 3,
            'unreadNotifications' => 6,

            'loans' => \array_slice($all, $offset, self::PER_PAGE),
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalItems' => $total,
            'rangeStart' => $total > 0 ? $offset + 1 : 0,
            'rangeEnd' => min($offset + self::PER_PAGE, $total),
        ]);
    }

      /**
     * Enregistrement de la signature électronique.
     *
     * Points de vigilance côté production :
     *  - le contenu signé doit être figé (hash SHA-256 du PDF au moment de la
     *    signature), sinon rien ne prouve QUOI a été signé ;
     *  - horodatage, adresse IP et user-agent constituent le faisceau de
     *    preuves exigé par eIDAS pour une signature électronique simple ;
     *  - l'image de signature est une donnée biométrique au sens du RGPD :
     *    stockage chiffré et durée de conservation limitée.
     */
    #[Route('/prets/demandes/{id}/signer', name: 'app_loan_sign', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function sign(Request $request, int $id): Response
    {
        if (!$this->isCsrfTokenValid('sign-loan', (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Requête invalide.');

            return $this->redirectToRoute('app_loan_requests');
        }

        if (!$request->request->getBoolean('acceptTerms')) {
            $this->addFlash('error', 'Vous devez accepter les conditions du contrat.');

            return $this->redirectToRoute('app_loan_requests');
        }

        $signature = (string) $request->request->get('signature');

        if ('' === $signature) {
            $this->addFlash('error', 'Aucune signature n\'a été fournie.');

            return $this->redirectToRoute('app_loan_requests');
        }

        // Deux formes acceptées : tracé manuscrit (PNG en data URL) ou nom saisi.
        if (str_starts_with($signature, 'typed:')) {
            $name = trim(substr($signature, 6));

            if (mb_strlen($name) < 3) {
                $this->addFlash('error', 'Le nom saisi est trop court pour valoir signature.');

                return $this->redirectToRoute('app_loan_requests');
            }
        } elseif (!$this->isAcceptableSignatureImage($signature)) {
            $this->addFlash('error', 'La signature transmise est invalide.');

            return $this->redirectToRoute('app_loan_requests');
        }

        // TODO : persister via LoanRepository —
        //   hash du contrat, image chiffrée, horodatage, IP, user-agent,
        //   puis passage du prêt au statut ACTIVE et envoi du PDF signé.
        $this->addFlash('success', 'Votre contrat a été signé. Une copie vous sera envoyée par e-mail.');

        return $this->redirectToRoute('app_loan_requests');
    }

    /**
     * Valide une signature manuscrite transmise en data URL.
     *
     * Le préfixe `data:image/png;base64,` est déclaré par le client : on
     * vérifie donc que le contenu décodé est bien un PNG, et non un fichier
     * arbitraire déguisé.
     */
    private function isAcceptableSignatureImage(string $dataUrl): bool
    {
        if (1 !== preg_match('#^data:image/png;base64,([A-Za-z0-9+/=]+)$#', $dataUrl, $matches)) {
            return false;
        }
        $binary = base64_decode($matches[1], true);
        if (false === $binary || \strlen($binary) > self::MAX_SIGNATURE_BYTES) {
            return false;
        }

        // Signature de fichier PNG (\x89PNG\r\n\x1a\n).
        return str_starts_with($binary, "\x89PNG\r\n\x1a\n");
    }
}