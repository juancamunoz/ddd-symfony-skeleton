<?php

namespace App\SharedKernel\Domain\Event;

abstract class DomainEvent extends Message
{
    protected function messageType(): string
    {
        return 'domain_event';
    }
}
