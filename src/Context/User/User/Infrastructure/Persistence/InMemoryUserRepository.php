<?php

namespace App\Context\User\User\Infrastructure\Persistence;

use App\Context\User\User\Domain\User;
use App\Context\User\User\Domain\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    private static array $users = [];
    public function save(User $user): void
    {
        self::$users[] = $user;
    }
}
