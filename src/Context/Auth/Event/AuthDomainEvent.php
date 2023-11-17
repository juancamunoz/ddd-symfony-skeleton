<?php

namespace App\Context\Auth\Event;

use App\SharedKernel\Domain\Event\DomainEvent;

abstract class AuthDomainEvent extends DomainEvent
{
    protected function boundedContext(): string
    {
        return 'auth';
    }
}
