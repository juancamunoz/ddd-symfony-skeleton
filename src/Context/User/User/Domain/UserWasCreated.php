<?php

namespace App\Context\User\User\Domain;

use App\SharedKernel\Domain\Event\DomainEvent;

class UserWasCreated extends DomainEvent
{
    const AGGREGATE_ROOT_ID_KEY = 'aggregate_root_id';

    public static function create(string $id): self
    {
        return new self([
            self::AGGREGATE_ROOT_ID_KEY => $id
        ]);
    }

    public function id(): string
    {
        return $this->get(self::AGGREGATE_ROOT_ID_KEY);
    }

    protected function boundedContext()
    {
        return 'users';
    }

    protected function messageName()
    {
        return 'user_created';
    }
}
