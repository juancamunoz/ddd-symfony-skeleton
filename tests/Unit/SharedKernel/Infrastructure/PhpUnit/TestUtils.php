<?php

namespace App\Tests\Unit\SharedKernel\Infrastructure\PhpUnit;

class TestUtils
{
    public static function similarTo($value, $delta = 0.0): MatcherIsSimilar
    {
        return new MatcherIsSimilar($value, $delta);
    }

    public static function isSimilar($expected, $actual): bool
    {
        $constraint = new MatcherIsSimilar($expected);

        return $constraint->evaluate($actual, '', true);
    }
}
