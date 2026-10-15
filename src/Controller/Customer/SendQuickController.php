<?php

namespace App\Controller\Customer;

use App\Entity\User;
use App\Repository\BanqueRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Utils\Common;
use Symfony\Component\Routing\Attribute\Route;

final class SendQuickController extends AbstractController
{

    private const PER_PAGE = 6;
        
    #[Route('/send_quicky',  name: 'app_customer_send_quicky')]
    public function sendQuicky(Request $request): Response
    {
        $query = trim($request->query->getString('q', ''));
        $status = $request->query->getString('status', '');
        $type = $request->query->getString('type', '');
        $period = $request->query->getString('period', '');

        $all = $this->history();

        if ('' !== $query) {
            $needle = mb_strtolower(str_replace(' ', '', $query));
            $all = array_values(array_filter($all, static function (array $t) use ($needle): bool {
                $haystack = mb_strtolower(str_replace(
                    ' ',
                    '',
                    $t['beneficiaryName'].$t['beneficiaryIban'].$t['reference'].$t['reason']
                ));
                return str_contains($haystack, $needle);
            }));
        }

        foreach (['status' => $status, 'type' => $type] as $field => $value) {
            if ('' === $value) {
                continue;
            }
            $all = array_values(array_filter(
                $all,
                static fn (array $t): bool => $t[$field] === $value
            ));
        }

        if ('' !== $period) {
            $days = ['7' => 7, '30' => 30, '90' => 90, '365' => 365][$period] ?? null;

            if (null !== $days) {
                $since = new \DateTimeImmutable("-{$days} days");
                $all = array_values(array_filter(
                    $all,
                    static fn (array $t): bool => $t['date'] >= $since
                ));
            }
        }

        $total = \count($all);
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));
        $page = $request->query->getInt('page', 1);
        $page = max(1, min($page, $totalPages));
        $offset = ($page - 1) * self::PER_PAGE;

        // Les totaux portent sur le résultat filtré : afficher un cumul global
        // sous une liste filtrée serait trompeur.
        $executed = array_filter($all, static fn (array $t): bool => 'executed' === $t['status']);
        return $this->render('customer/sendQuickly/send.html.twig', [
            'transfers' => \array_slice($all, $offset, self::PER_PAGE),
            'query' => $query,
            'statusFilter' => $status,
            'typeFilter' => $type,
            'periodFilter' => $period,

            'executedCount' => \count($executed),
            'executedAmount' => array_sum(array_column($executed, 'amount')),
            'pendingCount' => \count(array_filter($all, static fn (array $t): bool => 'pending' === $t['status'])),
            'scheduledCount' => \count(array_filter($all, static fn (array $t): bool => 'scheduled' === $t['status'])),

            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalItems' => $total,
            'rangeStart' => $total > 0 ? $offset + 1 : 0,
            'rangeEnd' => min($offset + self::PER_PAGE, $total),
        ]);
    }

      /**
     * Jeu de démonstration : 28 virements répartis sur quatre mois.
     *
     * @return array<int, array<string, mixed>>
     */
    private function history(): array
    {
        $beneficiaries = $this->beneficiaries();
        $accounts = $this->accounts();
        $rows = [
          /*   [1250.00, 'Paiement facture',        'executed',  'immediate', '-2 days'],
            [8500.00, 'Apport trimestriel',      'executed',  'immediate', '-4 days'],
            [320.00,  'Airbnb Dublin',           'executed',  'immediate', '-6 days'],
            [1150.00, 'Loyer octobre',           'scheduled', 'recurring', '+9 days'],
            [76.40,   'Courses',                 'executed',  'immediate', '-8 days'],
            [2400.00, 'Acompte fournisseur',     'pending',   'scheduled', '+2 days'],
            [45.99,   'Abonnement logiciel',     'executed',  'recurring', '-11 days'], */
            /* [3200.00, 'Règlement client Dupont', 'executed',  'immediate', '-13 days'],
            [890.00,  'Prestation freelance',    'rejected',  'immediate', '-15 days'],
            [1150.00, 'Loyer septembre',         'executed',  'recurring', '-21 days'],
            [180.00,  'Assurance habitation',    'executed',  'recurring', '-24 days'],
            [4200.00, 'Salaire équipe',          'executed',  'immediate', '-27 days'],
            [59.90,   'Téléphonie',              'executed',  'recurring', '-31 days'],
            [1150.00, 'Loyer août',              'executed',  'recurring', '-52 days'],
            [640.00,  'Matériel informatique',   'executed',  'immediate', '-58 days'],
            [95.00,   'Frais de dossier',        'rejected',  'immediate', '-63 days'],
            [1150.00, 'Loyer juillet',           'executed',  'recurring', '-83 days'],
            [2750.00, 'Acompte travaux',         'executed',  'immediate', '-88 days'],
            [130.00,  'Mutuelle',                'executed',  'recurring', '-92 days'],
            [410.00,  'Réparation véhicule',     'executed',  'immediate', '-97 days'],
            [1150.00, 'Loyer juin',              'executed',  'recurring', '-114 days'],
            [68.50,   'Fournitures',             'executed',  'immediate', '-120 days'],
            [5000.00, 'Virement épargne',        'executed',  'immediate', '-126 days'],
            [240.00,  'Formation en ligne',      'executed',  'immediate', '-133 days'],
            [1150.00, 'Loyer mai',               'executed',  'recurring', '-145 days'],
            [312.75,  'Déplacement',             'executed',  'immediate', '-151 days'],
            [1800.00, 'Prestation design',       'executed',  'immediate', '-158 days'],
            [99.00,   'Hébergement web',         'executed',  'recurring', '-164 days'], */
        ];

        $history = [];

        foreach ($rows as $index => [$amount, $reason, $status, $type, $offset]) {
            $beneficiary = $beneficiaries[$index % \count($beneficiaries)];
            $account = $accounts[$index % \count($accounts)];

            $history[] = [
                'id' => $index + 1,
                'reference' => 'VIR-2026-'.str_pad((string) (1420 - $index), 4, '0', \STR_PAD_LEFT),
                'date' => new \DateTimeImmutable($offset),
                'beneficiaryName' => $beneficiary['name'],
                'beneficiaryInitials' => $beneficiary['initials'],
                'beneficiaryIban' => $beneficiary['iban'],
                'debitAccountLabel' => $account['label'],
                'debitAccountLast4' => $account['last4'],
                'amount' => $amount,
                'currency' => 'EUR',
                'reason' => $reason,
                'status' => $status,
                'type' => $type,
            ];
        }

        return $history;
    }

    #[Route('/virements/nouveau', name: 'app_transfer_new', methods: ['GET'])]
    public function form(CountryRepository $countryRepository,
    BanqueRepository $banqueRepositoryy): Response
    {
        $accounts = $this->accounts();
        $connectedUser = $this->getUser();
        if(!$connectedUser instanceof User){}
        $countries = $countryRepository->findAll();
        $countryList = [];
        foreach($countries as $country){
                $countryList[] =  [
                    'code' => $country->getCodeIso2(),
                    'name' =>  $country->getLabel(),
                    'flag' =>  $country->getFlag()
                ];
        }
        $banques = $banqueRepositoryy->findAll();
        $bankList = [];
        foreach($banques as $bank){
                $bankList[] =  [
                    'country' => $bank->getCountryIso(),
                    'name' => $bank->getLabel(),       
                    'flag' => $bank->getLogo(),       
                    'short' => substr($bank->getCodeSwift(),0,3), 
                     'bic' =>$bank->getCodeSwift(),
                    'color' => Common::generateColor()
                ];
        }
        return $this->render('customer/sendQuickly/form.html.twig', [
            'accounts' => $accounts,
            'debitAccount' => $accounts[0],
            'beneficiaries' => $this->beneficiaries(),
            'prefill' => ['amount' => '', 'reason' => ''],
            // Contexte de l'assistant bénéficiaire inclus dans la page.
            'countries' => $countryList,
            'banks' => $bankList,
        ]);
    }

    /**
     * Soumission du virement.
     *
     * Le contrôle de solde est refait ici : celui du navigateur n'est qu'un
     * confort. Un virement doit par ailleurs être exécuté dans une transaction
     * unique avec verrou sur le compte débiteur, sinon deux requêtes
     * concurrentes peuvent chacune passer le contrôle et faire tomber le
     * solde en négatif.
     */
    #[Route('/virements/executer', name: 'app_transfer_submit', methods: ['POST'])]
    public function submit(Request $request): Response
    {
        if (!$this->isCsrfTokenValid('transfer', (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Requête invalide.');

            return $this->redirectToRoute('app_transfer_new');
        }

        $raw = str_replace([' ', ','], ['', '.'], (string) $request->request->get('amount'));
        $amount = is_numeric($raw) ? (float) $raw : 0.0;

        if ($amount <= 0) {
            $this->addFlash('error', 'Le montant du virement doit être supérieur à zéro.');

            return $this->redirectToRoute('app_transfer_new');
        }

        $type = (string) $request->request->get('transferType', 'immediate');

        if (\in_array($type, ['scheduled', 'recurring'], true)) {
            $date = (string) $request->request->get('executionDate');
            $parsed = \DateTimeImmutable::createFromFormat('Y-m-d', $date);

            if (false === $parsed || $parsed < new \DateTimeImmutable('today')) {
                $this->addFlash('error', "La date d'exécution doit être postérieure à aujourd'hui.");

                return $this->redirectToRoute('app_transfer_new');
            }
        }

        // L'ordre est enregistré en attente de confirmation, PAS exécuté.
        // On garde son empreinte en session : la page de validation ne doit
        // rien recevoir du navigateur, sinon il suffirait de modifier le
        // montant entre les deux écrans.
        $request->getSession()->set('pending_transfer', [
            'beneficiary' => (string) $request->request->get('beneficiary'),
            'debitAccount' => (string) $request->request->get('debitAccount'),
            'amount' => $amount,
            'currency' => (string) $request->request->get('currency', 'EUR'),
            'reason' => (string) $request->request->get('reason'),
            'type' => $type,
            'executionDate' => (string) $request->request->get('executionDate'),
            'issuedAt' => time(),
        ]);

        // TODO : dans une transaction Doctrine —
        //   1. verrouiller le compte débiteur (SELECT ... FOR UPDATE) ;
        //   2. revérifier le solde disponible ;
        //   3. créer l'ordre au statut PENDING ;
        //   4. émettre l'OTP via le module 2FA (SMS + e-mail).
        return $this->redirectToRoute('app_transfer_verify');
    }

     /**
     * Saisie du code de validation.
     */
    #[Route('/virements/validation', name: 'app_transfer_verify', methods: ['GET'])]
    public function verify(Request $request): Response
    {
        $pending = $request->getSession()->get('pending_transfer');

        // Sans ordre en attente, cette page n'a pas de sens : on renvoie au
        // formulaire plutôt que d'afficher un écran de saisie orphelin.
        if (!\is_array($pending)) {
            return $this->redirectToRoute('app_transfer_new');
        }

        $beneficiaries = $this->beneficiaries();
        $accounts = $this->accounts();

        $beneficiary = Common::pickById($beneficiaries, $pending['beneficiary']) ?? $beneficiaries[0];
        $account = Common::pickById($accounts, $pending['debitAccount']) ?? $accounts[0];

        $executionLabel = match ($pending['type']) {
            'scheduled' => 'Différé au '.Common::formatDate($pending['executionDate']),
            'recurring' => 'Programmé à partir du '.Common::formatDate($pending['executionDate']),
            default => 'Immédiate',
        };

        return $this->render('customer/verify_send.html.twig', [
            'codeLength' => 6,
            'codeTtl' => 300,
            'maskedPhone' => '•• •• •• •• 42',
            'transfer' => [
                'beneficiaryName' => $beneficiary['name'],
                'beneficiaryIban' => $beneficiary['iban'],
                'amount' => $pending['amount'],
                'currency' => $pending['currency'],
                'debitAccountLabel' => $account['label'].' •••• '.$account['last4'],
                'executionLabel' => $executionLabel,
            ],
        ]);
    }

    #[Route('/virements/validation', name: 'app_transfer_verify_submit', methods: ['POST'])]
    public function verifySubmit(Request $request): Response
    {
        if (!$this->isCsrfTokenValid('transfer-verify', (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Requête invalide.');

            return $this->redirectToRoute('app_transfer_verify');
        }

        $session = $request->getSession();
        $pending = $session->get('pending_transfer');

        if (!\is_array($pending)) {
            return $this->redirectToRoute('app_transfer_new');
        }

        // Le délai de validité se vérifie côté serveur : le compte à rebours
        // affiché est cosmétique et trivialement contournable.
        if (time() - $pending['issuedAt'] > 300) {
            $this->addFlash('error', 'Le code a expiré. Demandez-en un nouveau.');

            return $this->redirectToRoute('app_transfer_verify');
        }

        $code = preg_replace('/\D/', '', (string) $request->request->get('code'));

        if (6 !== \strlen((string) $code)) {
            $this->addFlash('error', 'Le code doit comporter 6 chiffres.');

            return $this->redirectToRoute('app_transfer_verify');
        }

        // TODO : vérifier le code via OtpService (comparaison à temps constant
        // sur un hash), compter les tentatives, puis exécuter le virement dans
        // une transaction avec verrou sur le compte débiteur.
        $session->remove('pending_transfer');

        $this->addFlash('success', 'Votre virement a été validé et sera exécuté sous peu.');

        return $this->redirectToRoute('app_transactions');
    }

     #[Route('/virements/validation/renvoyer', name: 'app_transfer_verify_resend', methods: ['POST'])]
    public function verifyResend(Request $request): Response
    {
        if (!$this->isCsrfTokenValid('transfer-resend', (string) $request->request->get('_token'))) {
            return $this->redirectToRoute('app_transfer_verify');
        }

        $session = $request->getSession();
        $pending = $session->get('pending_transfer');

        if (!\is_array($pending)) {
            return $this->redirectToRoute('app_transfer_new');
        }

        // TODO : borner les renvois (cooldown + quota), chaque SMS ayant un coût.
        $pending['issuedAt'] = time();
        $session->set('pending_transfer', $pending);

        $this->addFlash('success', 'Un nouveau code vous a été envoyé.');

        return $this->redirectToRoute('app_transfer_verify');
    }

        /**
     * Carnet de bénéficiaires du client.
     *
     * @return array<int, array<string, mixed>>
     */
    private function beneficiaries(): array
    {
        $connectedUser = $this->getUser();
        if(!$connectedUser instanceof User){}
        $externalAccounts = $connectedUser->getCustomer()->getExternalAccounts();
        $accountList = [];
        $i =1;
        foreach($externalAccounts as $account){
            $accountList[] =  [
                'id' => $i, 
                'name' => sprintf('%s %s', $account->getFirstname(), $account->getLastname()),  
                'initials' => sprintf('%s%s', strtoupper(substr($account->getFirstname(),0,1)),
                 strtoupper(substr($account->getLastname(),0,1))), 
                 'iban' => $account->getIban()
            ];
            $i++;
        }
        return $accountList;
    }


    /**
     * Comptes débiteurs du client.
     *
     * @return array<int, array<string, mixed>>
     */
    private function accounts(): array
    {
        $connectedUser = $this->getUser();
        if(!$connectedUser instanceof User){
            
        }
        $accounts = $connectedUser->getCustomer()->getAccounts()->filter( fn ($account) => $account->getPrincipal());
        $accountList = [];
        $i =1;
        foreach($accounts as $account){
            $accountList[] = [
                'id' => $i, 
                'label' =>$account->getLabel(), 
                'last4' => substr($account->getIban(),-4), 
                'currency' => $account->getDevise()->getCodeIso(), 
                'balance' =>$account->getAmount()];
            $i++;
        }
        return $accountList;
    }
}
