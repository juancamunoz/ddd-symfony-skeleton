<?php

namespace App\Tests\Unit\SharedKernel;

use App\Tests\Unit\SharedKernel\Infrastructure\PhpUnit\TestUtils;
use PHPUnit\Framework\TestCase;

class UnitTestCase extends TestCase
{
    protected function similarTo($value)
    {
        return TestUtils::similarTo($value);
    }
}
