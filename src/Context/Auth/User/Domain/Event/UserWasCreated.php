<?php

namespace App\Context\Auth\User\Domain\Event;

use App\SharedKernel\Domain\Event\DomainEvent;

class UserWasCreated extends DomainEvent
{
    const AGGREGATE_ROOT_ID_KEY = 'aggregate_root_id';
    const EMAIL_KEY = 'email';

    public static function create(string $id, string $email): self
    {
        return new self([
            self::AGGREGATE_ROOT_ID_KEY => $id,
            self::EMAIL_KEY => $email
        ]);
    }

    public function id(): string
    {
        return $this->get(self::AGGREGATE_ROOT_ID_KEY);
    }

    public function email(): string
    {
        return $this->get(self::EMAIL_KEY);
    }

    protected function boundedContext(): string
    {
        return 'users';
    }

    protected function messageName(): string
    {
        return 'user_created';
    }
}
