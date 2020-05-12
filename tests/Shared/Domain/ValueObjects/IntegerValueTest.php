<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\IntegerValue;
use PHPUnit\Framework\TestCase;

class IntegerForTest extends IntegerValue
{
}

class IntegerValueTest extends TestCase
{
    public function testIntegerValueCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new IntegerForTest();
    }

    public function testIntegerValueIsAccessible()
    {
        $integer = IntegerForTest::build(12);

        self::assertEquals(12, $integer->value());
    }

    public function testEqualsFunction()
    {
        $integer = IntegerForTest::build(14);

        self::assertTrue($integer->equals(IntegerForTest::build(14)));
        self::assertFalse($integer->equals(IntegerForTest::build(15)));
    }
}
