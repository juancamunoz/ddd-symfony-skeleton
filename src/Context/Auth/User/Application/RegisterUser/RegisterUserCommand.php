<?php

namespace App\Context\Auth\User\Application\RegisterUser;

use App\Context\Auth\Event\AuthCommand;

class RegisterUserCommand extends AuthCommand
{
    private const ID_KEY = 'id';
    private const EMAIL_KEY = 'email';

    public static function create(string $id, string $email): self
    {
        return new self([
            self::ID_KEY => $email,
            self::EMAIL_KEY => $email
        ]);
    }

    public function id(): string
    {
        return $this->get(self::ID_KEY);
    }

    public function email(): string
    {
        return $this->get(self::EMAIL_KEY);
    }

    protected function messageName(): string
    {
        return 'user.create_user';
    }
}
