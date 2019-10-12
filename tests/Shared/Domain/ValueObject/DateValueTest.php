<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObject;

use App\Shared\Domain\ValueObject\DateValue;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DateValueForTest extends DateValue {

}

class DateValueTest extends TestCase
{
    const DATE = '2018-01-01';
    const DATE_DIFFERENT = '2018-01-02';

    /**
     * @group Shared
     * @group Domain
     */
    const DATE_WITH_TIMEZONE = '2018-02-01T00:00:00.000000Z';

    const DATE2 = '2018-02-01';

    public function testDateCannotBeInstantiated()
    {
        self::expectException(\Error::class);

        new DateValueForTest();
    }

    /**
     * @group Shared
     * @group Domain
     *
     * @throws \Exception
     */
    public function testDateCanBeCreated()
    {
        $date = DateValueForTest::build(self::DATE);

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
        DateValueForTest::build('2018-15-32');
    }

    /**
     * @group Shared
     * @group Domain
     *
     * @throws \Exception
     */
    public function testDateStoresCorrectValue()
    {
        $date = DateValueForTest::build(self::DATE2);

        self::assertEquals(self::DATE_WITH_TIMEZONE, $date->value());
    }

    /**
     * @group Shared
     * @group Domain
     * @throws \Exception
     */
    public function testEqualsFunction()
    {
        $integer = DateValueForTest::build(self::DATE);

        self::assertTrue($integer->equals(DateValueForTest::build(self::DATE)));
        self::assertFalse($integer->equals(DateValueForTest::build(self::DATE2)));
    }
}
