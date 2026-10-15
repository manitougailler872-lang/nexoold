<?php

namespace App\Controller\Customer;

use App\Utils\Common;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/customer')]
final class BeneficaryController extends AbstractController
{
    private const PER_PAGE = 6;
/**
     *  ********************FIN GESTION DES CARTES*******************
     * */

    #[Route('/beneficiaries',  name: 'app_customer_external_accounts')]
    public function externalAccounts(Request $request): Response
    {
         $query = trim($request->query->getString('q', ''));
         $status = $request->query->getString('status', '');
         $status = \in_array($status, ['validated', 'pending'], true) ? $status : '';

         // Tous les bénéficiaires
        $all = Common::buildBeneficiaryDataset($this->getUser());
        if ('' !== $query) {
            $needle = mb_strtolower($query);
            $all = array_values(array_filter($all, static function (array $b) use ($needle): bool {
                $haystack = mb_strtolower($b['name'].' '.$b['bank'].' '.str_replace(' ', '', $b['iban']));
                return str_contains($haystack, str_replace(' ', '', $needle));
            }));
        }

         if ('' !== $status) {
            $wantVerified = 'validated' === $status;
            $all = array_values(array_filter(
                $all,
                static fn (array $b): bool => $b['verified'] === $wantVerified
            ));
        }

        $total = \count($all);
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));
        $page = $request->query->getInt('page', 1);
        $page = max(1, min($page, $totalPages));
        $offset = ($page - 1) * self::PER_PAGE;

        return $this->render('customer/external_accounts.html.twig', [
            'fullName' => 'Barry Armstrong',
            'initials' => 'BA',
            'accountLabel' => 'Compte principal',
            'currency' => 'EUR',
            'unreadMessages' => 3,
            'unreadNotifications' => 6,
            'externalAccounts' => \array_slice($all, $offset, self::PER_PAGE),
            'query' => $query,
            'statusFilter' => $status,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalItems' => $total,
            'rangeStart' => $total > 0 ? $offset + 1 : 0,
            'rangeEnd' => min($offset + self::PER_PAGE, $total),
            // Alimentent l'assistant d'ajout (étapes 1 et 2).
            'countries' => Common::countries(),
            'banks' => Common::banks(),
        ]);
    }

        /**
     * Création depuis l'assistant.
     *
     * L'assistant valide déjà l'IBAN côté navigateur (mod 97), mais cette
     * vérification est purement ergonomique : la requête POST reste
     * entièrement falsifiable. Le contrôle qui fait autorité est celui-ci.
     */
    #[Route('/beneficiaires/creer', name: 'app_beneficiary_create', methods: ['POST'])]
    public function create(Request $request, ValidatorInterface $validator): Response
    {
        if (!$this->isCsrfTokenValid('create-beneficiary', (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Requête invalide.');
            return $this->redirectToRoute('app_beneficiaries');
        }

        $iban = strtoupper(str_replace(' ', '', (string) $request->request->get('iban')));
        $bic = strtoupper(trim((string) $request->request->get('bic')));
        $firstname = trim((string) $request->request->get('firstname'));
        $lastname = trim((string) $request->request->get('lastname'));
        $country = (string) $request->request->get('country');
        $violations = $validator->validate($iban, [new Assert\NotBlank(), new Assert\Iban()]);

        if ('' !== $bic) {
            $violations->addAll($validator->validate($bic, [new Assert\Bic()]));
        }
        if ('' === $firstname || '' === $lastname) {
            $this->addFlash('error', 'Le nom et le prénom du bénéficiaire sont obligatoires.');
            return $this->redirectToRoute('app_beneficiaries');
        }
        if (\count($violations) > 0) {
            $this->addFlash('error', "L'IBAN ou le BIC saisi n'est pas valide.");
            return $this->redirectToRoute('app_beneficiaries');
        }

        // Le pays déclaré doit correspondre au préfixe de l'IBAN : un écart
        // trahit presque toujours une erreur de saisie.
        if ('' !== $country && !str_starts_with($iban, $country)) {
            $this->addFlash('error', "L'IBAN ne correspond pas au pays sélectionné.");
            return $this->redirectToRoute('app_beneficiaries');
        }

        // TODO : persister via BeneficiaireRepository avec le statut PENDING,
        // puis déclencher l'OTP de confirmation (voir le module 2FA).
        $this->addFlash(
            'success',
            \sprintf('%s %s a été ajouté. Confirmez-le par le code reçu par SMS.', $firstname, $lastname)
        );

        return $this->redirectToRoute('app_beneficiaries');
    }

    #[Route('/beneficiaires/{id}/editer', name: 'app_beneficiary_edit', requirements: ['id' => '\\d+'], methods: ['GET', 'POST'])]
    public function edit(int $id): Response
    {
        // TODO : réutiliser BeneficiaireType. Modifier un IBAN doit repasser
        // le bénéficiaire en PENDING et redéclencher une confirmation.
        return $this->render('dashboard/_placeholder.html.twig', [
            'pageTitle' => 'Éditer le bénéficiaire',
        ]);
    }

    #[Route('/beneficiaires/{id}/supprimer', name: 'app_beneficiary_delete', requirements: ['id' => '\\d+'], methods: ['POST'])]
    public function delete(Request $request, int $id): Response
    {
        if (!$this->isCsrfTokenValid('delete-beneficiary-'.$id, (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Requête invalide.');

            return $this->redirectToRoute('app_beneficiaries');
        }

        // TODO : vérifier que le bénéficiaire appartient bien au client
        // connecté avant suppression, puis journaliser l'action.
        $this->addFlash('success', 'Le bénéficiaire a été supprimé.');

        return $this->redirectToRoute('app_beneficiaries');
    }
}