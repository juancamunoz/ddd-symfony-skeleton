<?php

namespace App\SharedKernel\Domain\Bus\Event;

interface EventBus
{
    public function publish(DomainEvent ...$domainEvents): void;
}
