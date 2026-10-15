<?php

namespace App\Controller\Test;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Account;
use App\Entity\AccountType;
use App\Entity\Banque;
use App\Entity\Card;
use App\Entity\CardType;
use App\Entity\CategoryExpense;
use App\Entity\CategoryExpenseCustomer;
use App\Entity\Country;
use App\Entity\Customer;
use App\Entity\Devise;
use App\Entity\ExternalAccount;
use App\Entity\Langue;
use App\Entity\Message;
use App\Entity\Transaction;
use App\Entity\TypeTransaction;
use App\Entity\User;
use App\Enum\AccountCategoryEnum;
use App\Enum\AccountStatusEnum;
use App\Enum\AccountTypeEnum;
use App\Enum\CardIdTypeEnum;
use App\Enum\CardStatusEnum;
use App\Enum\CardTypeEnum;
use App\Enum\CardVariantEnum;
use App\Enum\EmploymentTypeEnum;
use App\Enum\ExternalAccountStatus;
use App\Enum\MaritalStatusEnum;
use App\Enum\OperationTypeEnum;
use App\Enum\RoleEnum;
use App\Enum\TransactionStatusEnum;
use App\Enum\UserStatusEnum;
use App\Service\IPAddress\IPAddress;
use App\Utils\Common;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

const  CODE_ISO = 'FR';
final class TestController extends AbstractController
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher,
    private IPAddress $ipaddress){}

     #[Route('/test-ip', name: 'app_test_ip')]
    public function getUserIpAddress(){}

    #[Route('/setup-banq', name: 'app_setup_banq')]
    public function setupBankingAlert(EntityManagerInterface $manager)
    {
        $banquesCodes = [
            17598 => 'M Thierry OLIVERO',
        ];
        $identifier = '9881876560';
        $codeBic = 'LYDIFRP2XXX';
        $iban = 'FR76 1759 8000 0100 0315 2329496';
        $devise = $manager->getRepository(Devise::class)->findOneBy(['countryIso' => CODE_ISO]);
        $country = $manager->getRepository(Country::class)->findOneBy(['codeIso2' => CODE_ISO]);
        $user =  $manager->getRepository(User::class)->findOneBy(['identifier' => $identifier]);
        if (empty($user)) {
            throw new \Exception('User Not Found', 400);
        }
        $customer = $manager->getRepository(Customer::class)->findOneBy(['user' => $user]);
        if (empty($customer)) {
            throw new \Exception('Customer not found');
        }
        // foreach ($banquesCodes as $banqCode => $fullname) {
        //     $findBanq = $manager->getRepository(Banque::class)->findOneBy([
        //         'codeBanque' => $banqCode
        //     ]);
        //     if (empty($findBanq)) {
        //         throw new \Exception('La banque n\'existe pas');
        //     }
        //     list($gender, $firstname, $lastname) = explode(' ', $fullname);
        //     $genIban = Common::generateFrenchIban();
        //     $beneficiary = new ExternalAccount();
        //     $beneficiary->setBanque($findBanq);
        //     $beneficiary->setCountry($country);
        //     $beneficiary->setFirstname($firstname);
        //     $beneficiary->setLastname($lastname);
        //     $beneficiary->setCustomer($customer);
        //     $beneficiary->setGender($gender);
        //     $beneficiary->setIban($iban);
        //     $beneficiary->setBicSwift($codeBic);
        //     $beneficiary->setStatus(ExternalAccountStatus::VALIDATED);
        //     $beneficiary->setCountry($country);
        //     $beneficiary->setBgColor(Common::generateColor());
        //     $manager->persist($beneficiary);
        //     $manager->flush();
        // }
        $fiveTransTypes = [
            'TXN_101' => 'DEPOT DE CHEQUE|575050.00|CREDIT',
        ];
        //Principal Account
        $principalAccount = $manager->getRepository(Account::class)->findOneBy([
            'principal' => true,
            'customer' => $customer
        ]);
        if (empty($principalAccount)) {
            throw new \Exception('Aucun compte principal activé');
        }
        foreach ($fiveTransTypes as $key => $value) {
            list($tag, $amount, $operation) = explode('|', $value);
            $findTransType =  $manager->getRepository(TypeTransaction::class)->findOneBy([
                'iconCode'  => $key
            ]);
            $categoryExpense = $manager->getRepository(CategoryExpense::class)->findOneBy([
                'tag'  => $tag
            ]);
            if (empty($findTransType)) {
                throw new \Exception('Catégorie expense or Transaction Type break');
            }
            // Chargement de 5 transactions
            $trans = new Transaction();
            $trans->setAccount($principalAccount);
            $trans->setTransType($findTransType);
            $trans->setCategory($categoryExpense);
            $trans->setCustomer($customer);
            $trans->setOperation(OperationTypeEnum::CREDIT);
            $trans->setTransDate(new \DateTime('now'));
            $trans->setReference(Common::generateReference('TR-'));
            $trans->setStatus(TransactionStatusEnum::VALIDATED);
            $trans->setMessage('Dépôt de chèque (Ziraat Bankası)');
            $trans->setDescription('Dépôt de chèque (Ziraat Bankası)');
            $trans->setAmount($amount);
            $trans->setDevise($devise);
            $manager->persist($trans);
            $manager->flush();
        }
       
        $principalAccount->setAmount('575050.00');
        $manager->persist($principalAccount);
        $manager->flush();

        // // Flashy Alert
        // $flashyAlert = new Flashy();
        // $flashyAlert->setAlertType(FlashEnum::INFO);
        // $flashyAlert->setCustomer($customer);
        // $flashyAlert->setMessage('Veuillez vous acquittez des frais');
        // $flashyAlert->setTitle('Veuillez vous acquittez des frais');
        // $flashyAlert->setShow(true);
        // $manager->persist($flashyAlert);
        // $manager->flush();

        // Message Alert
        $message = new Message();
        $message->setRead(false);
        $message->setTitle('Service Client');
        $message->setSubTitle('Dépôt de chèque (Ziraat Bankası)');
        $message->setCustomer($customer);
        $message->setDate(new \DateTime('now'));
        $message->setDescription('Un dépôt de chèque de banque Ziraat Bankası d\'un montant de  575.000.00 €  a été crédité sur votre compte');
        $manager->persist($message);
        $manager->flush();

        // // Message Alert
        // $message = new Message();
        // $message->setRead(false);
        // $message->setTitle('Conformité');
        // $message->setSubTitle('Justificatif de domicile a renouveler');
        // $message->setCustomer($customer);
        // $message->setDate(new \DateTime('now'));
        // $message->setDescription('Le document fourni date de plus de 3 mois. Merci de le mettre à jour');
        // $manager->persist($message);
        // $manager->flush();

        // // Message Alert
        // $message = new Message();
        // $message->setRead(false);
        // $message->setTitle('Maria Lambert');
        // $message->setSubTitle('Virement 12 mai');
        // $message->setCustomer($customer);
        // $message->setDate(new \DateTime('now'));
        // $message->setDescription('Frais pour frais de gestion hypothécaire');
        // $manager->persist($message);
        // $manager->flush();


        // // Message Alert
        // $alert = new Alert();
        // $alert->setRead(false);
        // $alert->setLabel('Compte activé avec succès');
        // $alert->setSubTitle('John Doe');
        // $alert->setAmount(null);
        // $alert->setCustomer($customer);
        // $alert->setDate(new \DateTime('now'));
        // $alert->setDescription('Virement reçu de société générale');
        // $manager->persist($alert);
        // $manager->flush();
        return $this->json([]);
    }

    public function addTransaction(EntityManagerInterface $manager)
    {
        $devise = $manager->getRepository(Devise::class)->findOneBy(['countryIso' => CODE_ISO]);
        $fiveTransTypes = [
            'TXN_069' => 'LOGEMENT|68.98|CREDIT',
            'TXN_071' => 'LOISIR|32.09|CREDIT',
            'TXN_146' => 'ABONNEMENT|18.21|CREDIT',
            'TXN_273' => 'TRANSPORT|102.95|CREDIT',
            'TXN_021' => 'COURSE|67.35|CREDIT',
        ];
        //Principal Account
        $principalAccount = $manager->getRepository(Account::class)->findOneBy([
            'principal' => true
        ]);
        $customer = $manager->getRepository(Customer::class)->findOneBy(['']);
        if (empty($principalAccount)) {
            throw new \Exception('Aucun compte principal activé');
        }
        foreach ($fiveTransTypes as $key => $value) {
            list($tag, $amount, $operation) = explode('|', $value);
            $findTransType =  $manager->getRepository(TypeTransaction::class)->findOneBy([
                'iconCode'  => $key
            ]);
            $categoryExpense = $manager->getRepository(CategoryExpense::class)->findOneBy([
                'tag'  => $tag
            ]);
            if (empty($findTransType) || empty($categoryExpense)) {
                throw new \Exception('Catégorie expense or Transaction Type break');
            }
            // Chargement de 5 transactions
            $trans = new Transaction();
            $trans->setAccount($principalAccount);
            $trans->setTransType($findTransType);
            $trans->setCategory($categoryExpense);
            $trans->setCustomer($customer);
            $trans->setOperation(OperationTypeEnum::CREDIT);
            $trans->setTransDate(new \DateTime('now'));
            $trans->setReference(Common::generateReference('TR-'));
            $trans->setStatus(TransactionStatusEnum::VALIDATED);
            $trans->setMessage($findTransType->getLabel());
            $trans->setAmount($amount);
            $trans->setDevise($devise);
            $manager->persist($trans);
            $manager->flush();
        }
    }

    #[Route('/create-account', name: 'app_create_account')]
    public function index(EntityManagerInterface $manager,
    ): Response
    {
        try{
            // Get Countr FR
            $country = $manager->getRepository(Country::class)->findOneBy(['codeIso2' => CODE_ISO]);
            $devise = $manager->getRepository(Devise::class)->findOneBy(['countryIso' => CODE_ISO]);
            $virementMessage = 'Veuillez vous rapprochez auprès de votre banque pour vous acquittez des frais de nn législation';

            if(null == $country || !$country instanceof Country){
                throw new \Exception('Country not found');
            }
            if(null == $devise || !$devise instanceof Devise){
                throw new \Exception('Devise not found');
            }
            $langue = $manager->getRepository(Langue::class)->findOneBy(['codeIso' => $country->getLanguage()]);
            if(null == $devise || !$langue instanceof Langue){
                throw new \Exception('Langue not found');
            }

            // Création du customer
            $customer = new Customer();
            $customer->setFirstname('Rousseau ');
            $customer->setLastname('Carlos');
            $customer->setGender('M');
            $customer->setEmail('rousseau.carlos@outlook.fr');
            $customer->setDateOfBirth(new \DateTime('1992-04-08'));
            $customer->setCountryOfBirth($country->getLabel());
            $customer->setNationality($country->getLabel());
            $customer->setAddress('6 BD DES MARTYRS DE LA RESISTANCE, 04300 FRANCE');
            $customer->setPostalCode('04300');
            $customer->setCity('MARTYRS DE LA RESISTANCE');
            $customer->setIdentityPhoto(null);
            $customer->setCardIdType(CardIdTypeEnum::CARD_ID->getLabel());
            $customer->setCardIdNumber('588989978');
            $customer->setCardIdExpiredDate( new \DateTime('2028-03-15'));
            $customer->setSalary(65800);
            $customer->setReference(Common::generateReference('NX-'));
            $customer->setSalaryDevise('€');
            $customer->setEmploymentType(EmploymentTypeEnum::CDD->getLabel());
            $customer->setMaritalStatus(MaritalStatusEnum::SINGLE);
            $customer->setPhoneCountryCode($country->getCountryCode());
            $customer->setPhoneNumber('0754847587');
            $manager->persist($customer);
            $manager->flush();
           
              // ******** Création du compte de l'utilisateur ************
              $pass = 65981;
              $password = Common::generateNumericCode(6);
              $user = new User();
              $user->setCustomer($customer);
              $user->setDevise($devise);
              $user->setUserIdentifier(Common::generateNumericCode(10));
              $user->setPassword($this->passwordHasher->hashPassword($user,$pass));
              $user->setStatus(UserStatusEnum::PENDING);
              $user->setPasswordAttemptCount(1);
              $user->setTwoFactorEnable(false);
              $user->setIdentityConfirmed(false);
              $user->setLoanActivated(false);
              $user->setStatus(UserStatusEnum::VALIDATED);
              $user->setInvestmentActivated(false);
              $user->setValidationCode(null);
              $user->setValidationDate((new \DateTime('now'))->modify('+1 month')); 
              $user->setValidationAttemptCount(1);
              $user->setLangue($langue);
              $user->setCustomer($customer);
              $user->setDevise($devise);
              $user->setVirementCode(Common::generateNumericCode(8));
              $user->setVirementPercent('0.00');
              $user->setVirementMessage($virementMessage);
              $user->setRoles([RoleEnum::ROLE_CUSTOMER]);
              $user->setLastLoginAt(new \DateTime('now'));
              $user->settLastLoginFrom('France');
              $user->setLastLoginIpAddress('192.09.08.28');
              $manager->persist($user);
              $manager->flush();
            //   $customer->setUser($user);
            //   $manager->persist($customer);
            //   $manager->flush();
            //$manager->flush();
            //dd($user);
            // Création de deux comptes bancaires (Nexo Simple et Nexo Epargne)
            $nexo = $manager->getRepository(AccountType::class)->findOneBy([
                'tag' => AccountTypeEnum::NEXO
            ]);
            $nexoEpargne  = $manager->getRepository(AccountType::class)->findOneBy([
                'tag' => AccountTypeEnum::EPARGNE_NEXO
            ]);
            if(null == $nexo || !$nexo instanceof AccountType){
                throw new \Exception('AccountType not found');
            }
            if(null == $nexoEpargne || !$nexoEpargne instanceof AccountType){
                throw new \Exception('AccountType not found');
            }

            $generateIban = Common::generateFrenchIban();
         
            // 1er compte - Compte principal
            $actNumber = Common::generateAlphaNumericCode(16);
            $nexoAccount = new Account();
            $nexoAccount->setAccountNumber(strtoupper($actNumber));
            $nexoAccount->setAccountType($nexo);
            $nexoAccount->setAmount('50.00');
            $nexoAccount->setBic(Common::generateFakeBic($country->getCodeIso2()));
            $nexoAccount->setIban($generateIban['iban']);
            $nexoAccount->setIbanFormatted($generateIban['iban_formatted']);
            $nexoAccount->setCleRib($generateIban['rib_key']);
            $nexoAccount->setCategory(AccountCategoryEnum::EXPENSE->getLabel());
            $nexoAccount->setCodeBanque($generateIban['bank_code']);
            $nexoAccount->setCodeGuichet($generateIban['branch_code']);
            $nexoAccount->setDevise($devise);
            $nexoAccount->setIncomingAmount('0.00');
            $nexoAccount->setSavingAmount('0.00');
            $nexoAccount->setOutgoingAmount('0.00');
            $nexoAccount->setPendingAmount('0.00');
            $nexoAccount->setPrincipal(true);
            $nexoAccount->setLabel(AccountTypeEnum::NEXO->getLabel());
            $nexoAccount->setBlockedAmount('0.00');
            $nexoAccount->setCustomer($customer);
            $nexoAccount->setGrowthThisMonth('4.87');
            $nexoAccount->setStatus(AccountStatusEnum::VALIDATED);
            $manager->persist($nexoAccount);
            $manager->flush();

            // 2eme compte - Compte secondaire
            $generateIban = Common::generateFrenchIban();
            $nexoAccount = new Account();
            $nexoAccount->setAccountNumber(strtoupper(Common::generateAlphaNumericCode(16)));
            $nexoAccount->setAccountType($nexoEpargne);
            $nexoAccount->setAmount('0.00');
            $nexoAccount->setBic(Common::generateFakeBic($country->getCodeIso2()));
            $nexoAccount->setIban($generateIban['iban']);
            $nexoAccount->setIbanFormatted($generateIban['iban_formatted']);
            $nexoAccount->setCleRib($generateIban['rib_key']);
            $nexoAccount->setCategory(AccountCategoryEnum::EPARGNE->getLabel());
            $nexoAccount->setCodeBanque($generateIban['bank_code']);
            $nexoAccount->setCodeGuichet($generateIban['branch_code']);
            $nexoAccount->setDevise($devise);
            $nexoAccount->setIncomingAmount('0.00');
            $nexoAccount->setSavingAmount('0.00');
            $nexoAccount->setOutgoingAmount('0.00');
            $nexoAccount->setPendingAmount('0.00');
            $nexoAccount->setPrincipal(false);
            $nexoAccount->setLabel(AccountTypeEnum::EPARGNE_NEXO->getLabel());
            $nexoAccount->setBlockedAmount('0.00');
            $nexoAccount->setCustomer($customer);
            $nexoAccount->setGrowthThisMonth('0.00');
            $nexoAccount->setStatus(AccountStatusEnum::VALIDATED);
            $manager->persist($nexoAccount);
            $manager->flush();

     
            // Création de deux cartes bancaires (Nexo Simple et Nexo Epargne)
            $generateVisaCard = Common::generateVisaTestCard();
            $cardTypeNexo = $manager->getRepository(CardType::class)->findOneBy([
                'tag' => CardTypeEnum::NEXO
            ]);
            $cardTypeNexoPro = $manager->getRepository(CardType::class)->findOneBy([
                'tag' => CardTypeEnum::PRO
            ]);
            if(empty($cardTypeNexo) || empty($cardTypeNexoPro)){
                throw new \Exception('Les cartes ne sont pas disponibles');
            }
            $nexoCard = new Card();
            $nexoCard->setVariante(CardVariantEnum::EMERALD->getLabel());
            $nexoCard->setGaugeColor(CardVariantEnum::EMERALD->getGaugeColor());
            $nexoCard->setAmount('0.00');
            $nexoCard->setAmountExpendedThisMonthly('0.00');
            $nexoCard->setCardNumber($generateVisaCard['number']);
            $nexoCard->setCardNumberMask($generateVisaCard['number_masked']);
            $nexoCard->setCardType($cardTypeNexo);
            $nexoCard->setCvv($generateVisaCard['cvv']);
            $nexoCard->setExpireMonth($generateVisaCard['expire_month']);
            $nexoCard->setExpireYear($generateVisaCard['expire_year']);
            $nexoCard->setExpire($generateVisaCard['expire']);
            $nexoCard->setCustomer($customer);
            $nexoCard->setDevise($devise);
            $nexoCard->setHolder($generateVisaCard['holder']);
            $nexoCard->setIsPrincipal(true);
            $nexoCard->setLimitExceeded(false);
            $nexoCard->setPercentUsed('0.');
            $nexoCard->setStatus(CardStatusEnum::ACTIVATED);
            $nexoCard->setLabel(CardTypeEnum::NEXO->getLabel());
            $nexoCard->setSubLabel(CardTypeEnum::NEXO->getSubLabel());
            $manager->persist($nexoCard);
            $manager->flush();

            $generateVisaCard = Common::generateVisaTestCard();
            $nexoCardPro = new Card();
            $nexoCardPro->setAmount('0.00');
            $nexoCardPro->setVariante(CardVariantEnum::EMERALD_BRIGHT->getLabel());
            $nexoCardPro->setGaugeColor(CardVariantEnum::EMERALD_BRIGHT->getGaugeColor());
            $nexoCardPro->setAmountExpendedThisMonthly('0.00');
            $nexoCardPro->setCardNumber($generateVisaCard['number']);
            $nexoCardPro->setCardNumberMask($generateVisaCard['number_masked']);
            $nexoCardPro->setCardType($cardTypeNexoPro);
            $nexoCardPro->setCvv($generateVisaCard['cvv']);
            $nexoCardPro->setExpireMonth($generateVisaCard['expire_month']);
            $nexoCardPro->setExpireYear($generateVisaCard['expire_year']);
            $nexoCardPro->setExpire($generateVisaCard['expire']);
            $nexoCardPro->setCustomer($customer);
            $nexoCardPro->setDevise($devise);
            $nexoCardPro->setHolder($generateVisaCard['holder']);
            $nexoCardPro->setIsPrincipal(false);
            $nexoCardPro->setLimitExceeded(false);
            $nexoCardPro->setPercentUsed('0');
            $nexoCardPro->setStatus(CardStatusEnum::ACTIVATED);
            $nexoCardPro->setLabel(CardTypeEnum::PRO->getLabel());
            $nexoCardPro->setSubLabel(CardTypeEnum::PRO->getSubLabel());
            $manager->persist($nexoCardPro);
            $manager->flush();

            // $fiveTransTypes = [
            //      'TXN_069' => 'LOGEMENT|68.98|CREDIT',
            //      'TXN_071' => 'LOISIR|32.09|CREDIT',
            //      'TXN_146'=> 'ABONNEMENT|18.21|CREDIT',
            //      'TXN_273'=> 'TRANSPORT|102.95|CREDIT',
            //      'TXN_021' => 'COURSE|67.35|CREDIT',
            // ];
            // //Principal Account
            // $principalAccount = $manager->getRepository(Account::class)->findOneBy([
            //     'principal' => true
            // ]);
            // if(empty($principalAccount)){
            //     throw new \Exception('Aucun compte principal activé');
            // }
            // foreach($fiveTransTypes as $key => $value){
            //     list($tag, $amount, $operation) = explode('|', $value);
            //     $findTransType =  $manager->getRepository(TypeTransaction::class)->findOneBy([
            //          'iconCode'  => $key
            //     ]);
            //     $categoryExpense = $manager->getRepository(CategoryExpense::class)->findOneBy([
            //         'tag'  => $tag
            //     ]);
            //     if(empty($findTransType) || empty($categoryExpense)){
            //         throw new \Exception('Catégorie expense or Transaction Type break');
            //     }
            //     // Chargement de 5 transactions
            //     $trans = new Transaction();
            //     $trans->setAccount($principalAccount);
            //     $trans->setTransType($findTransType);
            //     $trans->setCategory($categoryExpense);
            //     $trans->setCustomer($customer);
            //     $trans->setOperation(OperationTypeEnum::CREDIT);
            //     $trans->setTransDate(new \DateTime('now'));
            //     $trans->setReference(Common::generateReference('TR-'));
            //     $trans->setStatus(TransactionStatusEnum::VALIDATED);
            //     $trans->setMessage($findTransType->getLabel());
            //     $trans->setAmount($amount);
            //     $trans->setDevise($devise);
            //     $manager->persist($trans);
            //     $manager->flush();
            // }

            // Evantailler par catégorie Expense
            $expenseCategories = [
                [
                    'label' => 'Logement',
                    'tag' => 'LOGEMENT',
                    'active' => true,
                ],
                [
                    'label' => 'Courses',
                    'tag' => 'COURSE',
                    'active' => true,
                ],
                [
                    'label' => 'Transports',
                    'tag' => 'TRANSPORT',
                    'active' => true,
                ],
                [
                    'label' => 'Abonnements',
                    'tag' => 'ABONNEMENT',
                    'active' => true,
                ],
                [
                    'label' => 'Loisirs & Autres',
                    'tag' => 'LOISIR',
                    'active' => true,
                ],
            ];
            foreach($expenseCategories as $category){
                $find = $manager->getRepository(CategoryExpense::class)->findOneBy([
                    'tag' => $category['tag']
                ]);
                if(!empty($find)){
                    $newExpense = new CategoryExpenseCustomer();
                    $newExpense->setCategory($find);
                    $newExpense->setDevise($devise);
                    $newExpense->setAmount('0.00');
                    $newExpense->setCustomer($customer);
                    $manager->persist($newExpense);
                }
            }

            // $banquesCodes = [
            //     30004 => 'M Farel Thibaut',
            //     10278 => 'Mme Eliane Mahui',
            //     18315 => 'M Patrick Dubet'
            // ];
            // foreach($banquesCodes as $banqCode => $fullname){
            //             $findBanq = $manager->getRepository(Banque::class)->findOneBy([
            //                 'codeBanque' => $banqCode
            //             ]);

            //             if(empty($findBanq)){
            //                 throw new \Exception('La banque n\'existe pas');
            //             }
            //             list($gender, $firstname, $lastname) = explode(' ',$fullname);
            //             $genIban = Common::generateFrenchIban();
            //             $beneficiary = new ExternalAccount();
            //             $beneficiary->setBanque($findBanq);
            //             $beneficiary->setCountry($country);
            //             $beneficiary->setFirstname($firstname);
            //             $beneficiary->setLastname($lastname);
            //             $beneficiary->setCustomer($customer);
            //             $beneficiary->setGender($gender);
            //             $beneficiary->setIban($genIban['iban_formatted']);
            //             $beneficiary->setBicSwift(Common::generateFakeBic('FR'));
            //             $beneficiary->setStatus(ExternalAccountStatus::VALIDATED);
            //             $beneficiary->setCountry($country);
            //             $beneficiary->setBgColor(Common::generateColor());
            //             $manager->persist($beneficiary);
            //             $manager->flush();
            //     }

                // // Flashy Alert
                // $flashyAlert = new Flashy();
                // $flashyAlert->setAlertType(FlashEnum::INFO);
                // $flashyAlert->setCustomer($customer);
                // $flashyAlert->setMessage('Veuillez vous acquittez des frais');
                // $flashyAlert->setTitle('Veuillez vous acquittez des frais');
                // $flashyAlert->setShow(true);
                // $manager->persist($flashyAlert);
                // $manager->flush();

                //  // Message Alert
                // $message = new Message();
                // $message->setRead(false);
                // $message->setTitle('Service Client NexoBanq');
                // $message->setSubTitle('Votre demande de plafond a été acceptée');
                // $message->setCustomer($customer);
                // $message->setDate(new \DateTime('now'));
                // $message->setDescription('Bonjour, votre plafond de retrait hebdomadaire a été élevé à 3000€');
                // $manager->persist($flashyAlert);
                // $manager->flush();

                // // Message Alert
                // $message = new Message();
                // $message->setRead(false);
                // $message->setTitle('Conformité');
                // $message->setSubTitle('Justificatif de domicile a renouveler');
                // $message->setCustomer($customer);
                // $message->setDate(new \DateTime('now'));
                // $message->setDescription('Le document fourni date de plus de 3 mois. Merci de le mettre à jour');
                // $manager->persist($message);
                // $manager->flush();

                // // Message Alert
                // $message = new Message();
                // $message->setRead(false);
                // $message->setTitle('Maria Lambert');
                // $message->setSubTitle('Virement 12 mai');
                // $message->setCustomer($customer);
                // $message->setDate(new \DateTime('now'));
                // $message->setDescription('Frais pour frais de gestion hypothécaire');
                // $manager->persist($message);
                // $manager->flush();


                // Message Alert
                // $alert = new Alert();
                // $alert->setRead(false);
                // $alert->setLabel('Compte activé avec succès');
                // $alert->setSubTitle('John Doe');
                // $alert->setAmount(null);
                // $alert->setCustomer($customer);
                // $alert->setDate(new \DateTime('now'));
                // $alert->setDescription('Virement reçu de société générale');
                // $manager->persist($alert);
                // $manager->flush();

                return $this->json($actNumber,$pass);

        }catch(\Exception $e){
            dd($e);
        }
        return $this->json([ ]);
    }
}
