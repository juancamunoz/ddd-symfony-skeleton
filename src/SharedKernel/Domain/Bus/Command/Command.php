<?php

namespace App\SharedKernel\Domain\Bus\Command;

use App\SharedKernel\Domain\Event\Message;

abstract class Command extends Message
{
    protected function messageType(): string
    {
        return 'command';
    }
}
