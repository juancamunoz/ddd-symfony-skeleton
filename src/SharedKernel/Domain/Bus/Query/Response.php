<?php

namespace App\SharedKernel\Domain\Bus\Query;

interface Response
{
    public function result(): array;
}
