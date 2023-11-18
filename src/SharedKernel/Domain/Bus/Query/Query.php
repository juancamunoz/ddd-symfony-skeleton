<?php

namespace App\SharedKernel\Domain\Bus\Query;

use App\SharedKernel\Domain\Event\Message;

abstract class Query extends Message
{
    protected function messageType(): string
    {
        return 'query';
    }
}
