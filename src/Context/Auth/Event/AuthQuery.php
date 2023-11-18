<?php

namespace App\Context\Auth\Event;

use App\SharedKernel\Domain\Bus\Query\Query;

abstract class AuthQuery extends Query
{
    protected function boundedContext(): string
    {
        return 'auth';
    }
}
