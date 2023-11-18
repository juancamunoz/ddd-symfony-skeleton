<?php

namespace App\SharedKernel\Domain\Aggregate\Exception;

use App\SharedKernel\Domain\Aggregate\AggregateRoot;

class AggregateNotFoundException extends \DomainException
{
    public static function fromAggregate(string $aggregate): self
    {
        return new self(sprintf('Aggregate %s not found', $aggregate));
    }
}
