<?php

namespace App\SharedKernel\Infrastructure\Symfony\Security;

use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Lcobucci\JWT\Signer\Key\InMemory;

class JwtAuthenticator extends AbstractAuthenticator
{
    private string $jwt;
    private Parser $jwtParser;

    public function __construct(private readonly string $base64RsaKey)
    {
        $this->jwtParser = new Parser(new JoseEncoder());
    }

    public function supports(Request $request): ?bool
    {
        $token = $request->headers->get('Authorization');
        $explodedToken = explode(' ', $token);

        $this->jwt = $explodedToken[1] ?? '';

        try {
            $token = $this->jwtParser->parse($this->jwt);

            $validator = new Validator();

            $validator->validate($token, new SignedWith(
                new Sha256(),
                InMemory::base64Encoded($this->base64RsaKey)
            ));
        } catch (\Exception) {
            return false;
        }

        return !empty($this->jwt);
    }

    public function authenticate(Request $request): Passport
    {
        return new SelfValidatingPassport(new UserBadge($this->jwt));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return null;
    }
}
