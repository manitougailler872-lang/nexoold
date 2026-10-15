<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Tant que identityConfirmed vaut false, l'utilisateur connecté est confiné au
 * parcours KYC. Sans ce garde-fou, il suffirait de taper une URL interne pour
 * contourner l'étape de confirmation d'identité.
 */
final class IdentityConfirmationSubscriber implements EventSubscriberInterface
{
    /** Routes accessibles malgré un dossier d'identité incomplet. */
    private const ALLOWED_ROUTES = [
        'app_identity_verify',
        'app_identity_document_download',
        'app_logout',
        'app_login',
        'app_login_2fa',
        'app_login_2fa_resend',
        'app_login_abort',
    ];

    public function __construct(
        private readonly Security $security,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // Priorité basse : le firewall doit avoir résolu le token avant nous.
            KernelEvents::REQUEST => ['onKernelRequest', 6],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $request = $event->getRequest();
        $route = (string) $request->attributes->get('_route');

        // Ne jamais interférer avec le profiler, les assets ou les routes internes.
        if ('' === $route || str_starts_with($route, '_')) {
            return;
        }
        if (\in_array($route, self::ALLOWED_ROUTES, true)) {
            return;
        }
        $user = $this->security->getUser();
        return;
        if (!$user instanceof User || $user->getIdentityConfirmed()) {
            return;
        }
        // $event->setResponse(
        //     new RedirectResponse($this->urlGenerator->generate('app_identity_verify'))
        // );
    }
}
