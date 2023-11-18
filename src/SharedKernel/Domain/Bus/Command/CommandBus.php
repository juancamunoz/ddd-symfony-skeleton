<?php

namespace App\SharedKernel\Domain\Bus\Command;

interface CommandBus
{
    public function dispatch(Command $command): void;
}
