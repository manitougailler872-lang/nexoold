<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * État intermédiaire entre « mot de passe correct » et « OTP validé ».
 *
 * Choix d'architecture important : tant que l'OTP n'est pas validé, l'utilisateur
 * n'est PAS authentifié auprès du firewall Symfony. On ne stocke en session qu'un
 * identifiant technique et un horodatage. Quelqu'un qui ne connaît que le code à
 * 6 chiffres n'obtient donc aucun jeton de session exploitable.
 *
 * La session est régénérée à l'entrée (anti-fixation) et à la connexion effective.
 */
final class PendingLoginStore
{
    private const KEY_USER_ID = '_2fa.user_id';
    private const KEY_STARTED_AT = '_2fa.started_at';

    /** Durée de vie de l'étape 2FA : au-delà, on repart du formulaire de connexion. */
    public const PENDING_TTL = 900; // 15 minutes

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function start(User $user): void
    {
        $session = $this->requestStack->getSession();
        // Anti-fixation : nouvel identifiant de session dès l'étape 1 réussie.
        $session->migrate(true);

        $session->set(self::KEY_USER_ID, $user->getId()->toRfc4122());
        $session->set(self::KEY_STARTED_AT, time());
    }

    public function getPendingUser(): ?User
    {
        $session = $this->requestStack->getSession();

        $userId = $session->get(self::KEY_USER_ID);
        $startedAt = $session->get(self::KEY_STARTED_AT);

        if (!\is_string($userId) || !\is_int($startedAt)) {
            return null;
        }

        if ($startedAt + self::PENDING_TTL < time()) {
            $this->clear();

            return null;
        }

        $user = $this->userRepository->find($userId);

        if (null === $user) {
            $this->clear();

            return null;
        }

        return $user;
    }

    public function hasPending(): bool
    {
        return null !== $this->getPendingUser();
    }

    public function clear(): void
    {
        $session = $this->requestStack->getSession();

        $session->remove(self::KEY_USER_ID);
        $session->remove(self::KEY_STARTED_AT);
    }
}
