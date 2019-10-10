<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValue;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class StringValueTest extends TestCase
{
    /**
     * @group Shared
     * @group Domain
     */
    public function testStringValueCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new StringValue();
    }

    /**
     * @group Shared
     * @group Domain
     */
    public function testStringValueIsAccessible()
    {
        $string = StringValue::build('test');

        self::assertEquals('test', $string->value());
    }
}
