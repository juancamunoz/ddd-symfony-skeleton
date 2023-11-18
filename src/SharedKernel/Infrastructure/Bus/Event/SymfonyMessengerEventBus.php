<?php

namespace App\SharedKernel\Infrastructure\Bus\Event;

use App\SharedKernel\Domain\Bus\Event\DomainEvent;
use App\SharedKernel\Domain\Bus\Event\EventBus;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyMessengerEventBus implements EventBus
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    public function publish(DomainEvent ...$domainEvents): void
    {
        foreach ($domainEvents as $domainEvent) {
            $stamp = new AmqpStamp($domainEvent->name());
            $this->bus->dispatch(new Envelope($domainEvent, [$stamp]));
        }
    }
}
