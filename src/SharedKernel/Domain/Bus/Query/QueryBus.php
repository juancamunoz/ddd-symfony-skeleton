<?php

namespace App\SharedKernel\Domain\Bus\Query;

interface QueryBus
{
    public function ask(Query $query): Response;
}
