<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValue;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;


class StringForTest extends StringValue
{

}

class StringValueTest extends TestCase
{
    /**
     * @group Shared
     * @group Domain
     */
    public function testStringValueCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new StringForTest();
    }

    /**
     * @group Shared
     * @group Domain
     */
    public function testStringValueIsAccessible()
    {
        $string = StringForTest::build('test');

        self::assertEquals('test', $string->value());
    }

    /**
     * @group Shared
     * @group Domain
     */
    public function testEqualsFunction()
    {
        $integer = StringForTest::build('test');

        self::assertTrue($integer->equals(StringForTest::build('test')));
        self::assertFalse($integer->equals(StringForTest::build('test_not_equal')));
    }
}
