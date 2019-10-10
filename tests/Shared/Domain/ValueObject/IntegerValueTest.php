<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObject;

use App\Shared\Domain\ValueObject\IntegerValue;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class IntegerValueTest extends TestCase
{
    /**
     * @group Shared
     * @group Domain
     */
    public function testIntegerValueCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new IntegerValue();
    }

    /**
     * @group Shared
     * @group Domain
     */
    public function testIntegerValueIsAccessible()
    {
        $integer = IntegerValue::build(12);

        self::assertEquals(12, $integer->value());
    }
}
