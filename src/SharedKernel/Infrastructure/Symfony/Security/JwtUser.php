<?php

namespace App\SharedKernel\Infrastructure\Symfony\Security;


use Symfony\Component\Security\Core\User\UserInterface;
use function Lambdish\Phunctional\filter_fresh;

class JwtUser implements UserInterface
{
    private string $identifier;
    private array $roles;
    public function __construct(array $payload)
    {
        $this->identifier = $payload['preferred_username'];
        $this->roles = filter_fresh(fn (string $role) => str_starts_with($role, 'ROLE_'), $payload['realm_access']['roles']);
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->identifier;
    }
}
