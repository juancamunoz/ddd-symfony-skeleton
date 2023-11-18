<?php

namespace App\Context\Auth\Event;

use App\SharedKernel\Domain\Bus\Command\Command;

abstract class AuthCommand extends Command
{
    protected function boundedContext(): string
    {
        return 'auth';
    }
}
