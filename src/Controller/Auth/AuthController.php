<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Entity\User;
use App\Enum\UserStatusEnum;
use App\Form\LoginType;
use App\Form\TwoFactorCodeType;
use App\Repository\UserRepository;
use App\Security\LoginAuthenticator;
use App\Security\PendingLoginStore;
use App\Service\Otp\OtpService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Parcours de connexion en deux étapes.
 *   1. POST /connexion        → identifiant (10 chiffres) + code secret (6 chiffres)
 *   2. POST /connexion/code   → OTP reçu par SMS et e-mail, valable 5 minutes
 *   3. redirection vers /identite si identityConfirmed === false
 *
 * L'authentification effective (Security::login) n'a lieu qu'à l'étape 2.
 */
class AuthController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly PendingLoginStore $pendingLogin,
        private readonly OtpService $otpService,
        private readonly EntityManagerInterface $em,
        private readonly LoggerInterface $logger,
        private readonly RateLimiterFactory $loginLimiter,
        private readonly RateLimiterFactory $otpLimiter,
        private readonly RateLimiterFactory $otpResendLimiter,
        private readonly Security $security,
    ) {
    }

    #[Route('/connexion', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_customer_dashboard');
        }

        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                // Limitation par IP : coupe le bruteforce distribué sur l'identifiant.
                $limiter = $this->loginLimiter->create($request->getClientIp() ?? 'unknown');

                if (!$limiter->consume()->isAccepted()) {
                    $this->logger->warning('Limite de tentatives de connexion atteinte.', [
                        'ip' => $request->getClientIp(),
                    ]);
                    return $this->render('auth/signin.html.twig', [
                        'form' => $form,
                        'error' => 'Trop de tentatives. Réessayez dans quelques minutes.',
                    ], new Response('', Response::HTTP_TOO_MANY_REQUESTS));
                }

                $data = $form->getData();
    
                $user = $this->userRepository->findOneBy(['identifier' => $data['accountNumber']]);
                $error = $this->authenticateCredentials($user, (string) $data['secretCode']);

                if (null !== $error) {
                    return $this->render('auth/signin.html.twig', [
                        'form' => $form,
                        'error' => $error,
                    ], new Response('', Response::HTTP_UNAUTHORIZED));
                }

                /** @var User $user */
                $user->setPasswordAttemptCount(0);
                $this->em->flush();

                // 2FA désactivée : on connecte directement (cas de comptes de service).
                if (!$user->getTwoFactorEnable()) {
                    return $this->completeLogin($request, $user);
                }
                $this->pendingLogin->start($user);
                $dispatch = $this->otpService->issue($user);
                $this->addFlash($dispatch->anySent() ? 'success' : 'error', $dispatch->userMessage());
                return $this->redirectToRoute('app_login_2fa');
        }
        return $this->render('auth/signin.html.twig', [
            'form' => $form,
            'error' => null,
        ]);
    }

    /**
     * Vérifie identifiant + code secret.
     * @return string|null message d'erreur générique, ou null si tout est bon
     */
    private function authenticateCredentials(?User $user, string $secretCode): ?string
    {
        // Message unique quel que soit le motif : on ne révèle jamais si
        // l'identifiant existe (évite l'énumération de comptes).
        $generic = 'Identifiant ou code secret invalide.';
        $secret = explode(',',$secretCode);

        // Permet de vérifier si le code renseigner est égale à 6.
        // Le code secret doit contenir 6 caractères.
        if(empty($secret) || count($secret) < 5){
            return $generic;
        }
        $secret = intval(implode('',$secret));
        if (null === $user) {
            // Hachage factice : le temps de réponse reste comparable au cas
            // « compte existant », ce qui neutralise l'attaque temporelle.
            $this->passwordHasher->hashPassword(new User(), (string)$secret);
            return $generic;
        }

        if (UserStatusEnum::AUTHORIZE !== $user->getStatus() && UserStatusEnum::VALIDATED !== $user->getStatus()) {
            return 'Ce compte n\'est pas encore actif. Contactez le service client.';
        }
        if ($user->getPasswordAttemptCount() >= 5) {
            return 'Compte temporairement bloqué après plusieurs échecs. Contactez le service client.';
        }
        //dd($secret);
        if (!$this->passwordHasher->isPasswordValid($user, (string)$secret)) {
            $user->incrementPasswordAttemptCount();
            if ($user->getPasswordAttemptCount() >= 5) {
                $user->setStatus(UserStatusEnum::BLOCKED);
                $this->logger->warning('Compte bloqué après 5 échecs de code secret.', [
                    'user' => $user->getId()->toRfc4122(),
                ]);
            }
            $this->em->flush();
            return $generic;
        }
        return null;
    }

    #[Route('/connexion/code', name: 'app_login_2fa', methods: ['GET', 'POST'])]
    public function twoFactor(Request $request): Response
    {
        $user = $this->pendingLogin->getPendingUser();

        if (null === $user) {
            $this->addFlash('error', 'Session expirée. Reprenez la connexion.');

            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(TwoFactorCodeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $limiter = $this->otpLimiter->create($user->getId()->toRfc4122());

            if (!$limiter->consume()->isAccepted()) {
                $this->pendingLogin->clear();

                return $this->redirectToRoute('app_login');
            }

            $result = $this->otpService->verify($user, (string) $form->getData()['code']);

            if ($result->isSuccess()) {
                return $this->completeLogin($request, $user);
            }

            $this->addFlash('error', $result->userMessage());

            return $this->redirectToRoute('app_login_2fa');
        }

        return $this->render('security/two_factor.html.twig', [
            'form' => $form,
            'maskedPhone' => $this->maskPhone($user),
            'maskedEmail' => $this->maskEmail($user),
            'ttlMinutes' => (int) (OtpService::OTP_TTL_SECONDS / 60),
            'canResend' => $this->otpService->canResend($user),
            'resendIn' => $this->otpService->secondsBeforeResend($user),
        ]);
    }

    #[Route('/connexion/code/renvoyer', name: 'app_login_2fa_resend', methods: ['POST'])]
    public function resend(Request $request): Response
    {
        $user = $this->pendingLogin->getPendingUser();

        if (null === $user) {
            return $this->redirectToRoute('app_login');
        }

        if (!$this->isCsrfTokenValid('resend-otp', (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Requête invalide.');

            return $this->redirectToRoute('app_login_2fa');
        }

        $limiter = $this->otpResendLimiter->create($user->getId()->toRfc4122());

        if (!$limiter->consume()->isAccepted()) {
            $this->addFlash('error', 'Trop de demandes de renvoi. Réessayez plus tard.');

            return $this->redirectToRoute('app_login_2fa');
        }

        if (!$this->otpService->canResend($user)) {
            $this->addFlash('error', \sprintf(
                'Merci de patienter %d secondes avant de demander un nouveau code.',
                $this->otpService->secondsBeforeResend($user)
            ));

            return $this->redirectToRoute('app_login_2fa');
        }

        $dispatch = $this->otpService->issue($user);
        $this->addFlash($dispatch->anySent() ? 'success' : 'error', $dispatch->userMessage());

        return $this->redirectToRoute('app_login_2fa');
    }

    /**
     * Authentifie réellement l'utilisateur puis l'oriente selon son état KYC.
     */
    private function completeLogin(Request $request, User $user): Response
    {
        $this->pendingLogin->clear();
        // Nouvelle régénération de session au moment de l'élévation de privilège.
        $request->getSession()->migrate(true);

        $user->setLastLoginAt(new \DateTime());
        $user->setPasswordAttemptCount(0);
        $user->touch();
        $this->em->flush();
        $request->getSession()->set('accountNumber', $user->getUserIdentifier());

        // Symfony 6.2+ : connexion programmatique sur le firewall « main ».
        // C'est ici, et seulement ici, que l'utilisateur devient authentifié.
        $this->security->login(
        $user,
        LoginAuthenticator::class,
        'main'
    );
        $this->logger->info('Connexion réussie.', [
            'user' => $user->getId()->toRfc4122(),
            'ip' => $request->getClientIp(),
        ]);
       /*  if (!$user->getIdentityConfirmed()) {
            $this->addFlash('info', 'Dernière étape : confirmez votre identité pour activer votre compte.');
            return $this->redirectToRoute('app_identity_verify');
        } */
        return $this->redirectToRoute('app_customer_dashboard');
    }

    #[Route('/deconnexion', name: 'app_logout', methods: ['GET'])]
    public function logout(): never
    {
        throw new \LogicException('Interceptée par la clé "logout" du firewall dans security.yaml.');
    }

    #[Route('/connexion/abandon', name: 'app_login_abort', methods: ['GET'])]
    public function abort(): Response
    {
        $this->pendingLogin->clear();

        return $this->redirectToRoute('app_login');
    }

    private function maskPhone(User $user): string
    {
        $phone = $user->getCustomer()?->getPhoneNumber();

        if (null === $phone || \strlen($phone) < 4) {
            return '—';
        }

        return '•••• •••• '.substr($phone, -2);
    }

    private function maskEmail(User $user): string
    {
        // //$email = $user->getCustomer()?->getEmail();

        // if (null === $email || !str_contains($email, '@')) {
        //     return '—';
        // }

        // [$local, $domain] = explode('@', $email, 2);

        // return substr($local, 0, 1).str_repeat('•', max(3, \strlen($local) - 1)).'@'.$domain;
        return '';
    }
}
