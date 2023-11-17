<?php

namespace App\Tests\Unit\Auth\User\Domain;

use App\Context\Auth\User\Domain\User;

class UserMother
{
    private const DEFAULT_UUID = '636da888-b16d-485c-a0bd-cf506a376a0e';
    private const DEFAULT_EMAIL = 'test@test.com';

    public static function create(
        ?string $uuid = null,
        ?string $email = null
    ): User {
        return new User(
            $uuid ?? self::DEFAULT_UUID,
            $email ?? self::DEFAULT_EMAIL
        );
    }

    public static function default(): User
    {
        return self::create();
    }
}
