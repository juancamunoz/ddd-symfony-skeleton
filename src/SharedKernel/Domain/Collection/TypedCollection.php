<?php

namespace App\SharedKernel\Domain\Collection;

use function Lambdish\Phunctional\filter_fresh;

abstract class TypedCollection extends Collection
{
    abstract protected static function type(): string;

    public function __construct(array $elements = [])
    {
        $type = static::type();
        $elements = filter_fresh(fn ($item) => $item instanceof $type, $elements);
        parent::__construct($elements);
    }
}
