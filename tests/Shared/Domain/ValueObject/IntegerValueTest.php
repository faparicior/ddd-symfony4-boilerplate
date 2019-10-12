<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObject;

use App\Shared\Domain\ValueObject\IntegerValue;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class IntegerForTest extends IntegerValue {

}

class IntegerValueTest extends TestCase
{

    /**
     * @group Shared
     * @group Domain
     */
    public function testIntegerValueCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new IntegerForTest();
    }

    /**
     * @group Shared
     * @group Domain
     */
    public function testIntegerValueIsAccessible()
    {
        $integer = IntegerForTest::build(12);

        self::assertEquals(12, $integer->value());
    }

    /**
     * @group Shared
     * @group Domain
     */
    public function testEqualsFunction()
    {
        $integer = IntegerForTest::build(14);

        self::assertTrue($integer->equals(IntegerForTest::build(14)));
        self::assertFalse($integer->equals(IntegerForTest::build(15)));
    }
}
