<?php

namespace App\Context\User\User\Domain;

use App\SharedKernel\Domain\Aggregate\AggregateRoot;

class User extends AggregateRoot
{
    public function __construct(private readonly string $id)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public static function create(string $id): self
    {
        $user = new self($id);

        $user->record(UserWasCreated::create(
            $user->id()
        ));

        return $user;
    }
}
