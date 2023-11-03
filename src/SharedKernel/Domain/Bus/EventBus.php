<?php

namespace App\SharedKernel\Domain\Bus;

use App\SharedKernel\Domain\Event\DomainEvent;

interface EventBus
{
    public function publish(DomainEvent ...$domainEvents): void;
}
