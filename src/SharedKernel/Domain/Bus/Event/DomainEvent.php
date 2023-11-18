<?php

namespace App\SharedKernel\Domain\Bus\Event;

use App\SharedKernel\Domain\Event\Message;

abstract class DomainEvent extends Message
{
    protected function messageType(): string
    {
        return 'domain_event';
    }
}
