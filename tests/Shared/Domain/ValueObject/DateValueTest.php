<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObject;

use App\Shared\Domain\ValueObject\DateValue;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DateValueTest extends TestCase
{
    /**
     * @group Shared
     * @group Domain
     */
    public function testDateCannotBeInstantiated()
    {
        self::expectException(\Error::class);

        new DateValue();
    }

    /**
     * @group Shared
     * @group Domain
     *
     * @throws \Exception
     */
    public function testDateCanBeCreated()
    {
        $date = DateValue::build('2018-01-01');

        self::assertInstanceOf(DateValue::class, $date);
    }

    /**
     * @group Shared
     * @group Domain
     *
     * @throws \Exception
     */
    public function testCreateDateFailsForBadStringFormat()
    {
        self::expectException(\Exception::class);
        DateValue::build('2018-15-32');
    }

    /**
     * @group Shared
     * @group Domain
     *
     * @throws \Exception
     */
    public function testDateStoresCorrectValue()
    {
        $date = DateValue::build('2018-02-01');

        self::assertEquals('2018-02-01T00:00:00.000000Z', $date->value());
    }
}
