<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\DomainException;
use App\Shared\Domain\Exceptions\InvalidStringException;
use App\Shared\Domain\ValueObjects\StringValue;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class StringForTest extends StringValue
{
}

class StringValueTest extends TestCase
{
    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testStringValueCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new StringForTest();
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws InvalidStringException
     * @throws DomainException
     * @throws ReflectionException
     */
    public function testStringValueIsAccessible()
    {
        $string = StringForTest::build('test');

        self::assertEquals('test', $string->value());
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws DomainException
     * @throws InvalidStringException
     * @throws ReflectionException
     */
    public function testEqualsFunction()
    {
        $integer = StringForTest::build('test');

        self::assertTrue($integer->equals(StringForTest::build('test')));
        self::assertFalse($integer->equals(StringForTest::build('test_not_equal')));
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws DomainException
     * @throws InvalidStringException
     * @throws ReflectionException
     */
    public function testHasToStringMagicFunction()
    {
        $string = StringForTest::build('test');

        self::assertEquals('test', $string->__toString());
    }
}
