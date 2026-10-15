<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class LoginAuthenticator extends AbstractAuthenticator
{
    public function supports(Request $request): ?bool
    {
        // Cet authenticator n'intercepte pas automatiquement une route.
        // Il est utilisé explicitement avec Security::login().
        return false;
    }

    public function authenticate(Request $request): SelfValidatingPassport
    {
        throw new \LogicException(
            'LoginAuthenticator doit être utilisé via Security::login().'
        );
    }

    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $firewallName
    ): ?Response {
        return null;
    }

    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception
    ): ?Response {
        return null;
    }
}