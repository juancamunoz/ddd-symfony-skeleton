<?php

namespace App\SharedKernel\Infrastructure\Symfony\Security;

use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JwtUserProvider implements UserProviderInterface
{
    private Parser $jwtParser;

    public function __construct()
    {
        $this->jwtParser = new Parser(new JoseEncoder());
    }

    public function refreshUser(UserInterface $user)
    {
    }

    public function supportsClass(string $class)
    {
        return JwtUser::class === $class || is_subclass_of($class, JwtUser::class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return new JwtUser($this->jwtParser->parse($identifier)->claims()->all());
    }
}
