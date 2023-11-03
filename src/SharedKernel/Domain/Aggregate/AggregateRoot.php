<?php

namespace App\SharedKernel\Domain\Aggregate;

use App\SharedKernel\Domain\Event\DomainEvent;

abstract class AggregateRoot
{
    private array $domainEvents = [];

    protected function record(DomainEvent $event): void
    {
        $this->domainEvents[] = $event;
    }

    public function pullEvents(): array
    {
        $events = $this->domainEvents;

        $this->domainEvents = [];

        return $events;
    }
}
