<?php

namespace App\SharedKernel\Infrastructure\Bus\Query;

use App\SharedKernel\Domain\Bus\Query\Query;
use App\SharedKernel\Domain\Bus\Query\QueryBus;
use App\SharedKernel\Domain\Bus\Query\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonyMessengerQueryBus implements QueryBus
{
    public function __construct(private readonly MessageBusInterface $queryBus)
    {
    }

    public function ask(Query $query): Response
    {
        $envelope = $this->queryBus->dispatch($query);

        /** @var HandledStamp[] $handledStamps */
        $handledStamps = $envelope->all(HandledStamp::class);

        return $handledStamps[0]->getResult();
    }
}
