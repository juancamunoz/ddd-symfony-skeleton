<?php

namespace App\Context\Auth\User\Domain;

use App\Context\Auth\User\Domain\Event\UserWasCreated;
use App\SharedKernel\Domain\Aggregate\AggregateRoot;

class User extends AggregateRoot
{
    public function __construct(private readonly string $id, private readonly string $email)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

    public static function create(string $id, string $email): self
    {
        $user = new self($id, $email);

        $user->record(UserWasCreated::create(
            $user->id(),
            $user->email()
        ));

        return $user;
    }
}
