<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\StringValue;
use PHPUnit\Framework\TestCase;

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
     * @throws \App\Shared\Domain\Exceptions\InvalidStringException
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
     * @throws \App\Shared\Domain\Exceptions\InvalidStringException
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
     * @throws \App\Shared\Domain\Exceptions\InvalidStringException
     */
    public function testHasToStringMagicFunction()
    {
        $string = StringForTest::build('test');

        self::assertEquals('test', $string->__toString());
    }
}
