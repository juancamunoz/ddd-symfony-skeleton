<?php

namespace App\SharedKernel\Infrastructure\Bus\Command;

use App\SharedKernel\Domain\Bus\Command\Command;
use App\SharedKernel\Domain\Bus\Command\CommandBus;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyMessengerCommandBus implements CommandBus
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    public function dispatch(Command $command): void
    {
        $stamp = new AmqpStamp($command->name());
        $this->bus->dispatch(Envelope::wrap($command, [$stamp]));
    }
}
