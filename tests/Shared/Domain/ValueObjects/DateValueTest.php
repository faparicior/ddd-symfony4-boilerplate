<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\DateValue;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DateValueForTest extends DateValue {

}

class DateValueTest extends TestCase
{
    const DATE = '2018-01-01';
    const DATE_DIFFERENT = '2018-01-02';
    const DATE_WITH_TIMEZONE = '2018-02-01T00:00:00.000000Z';
    const DATE_WITH_TIMEZONE_PLUS_ONE = '2018-02-01T01:00:00.000000Z';
    const DATE2 = '2018-02-01';

    const UTC_TIMEZONE = 'UTC';
    const ASIA_SHANGHAI_TIMEZONE = 'Asia/Shanghai';
    const ASIA_SHANGHAI_UTC_DIFF_HOURS = 8;

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testDateCannotBeInstantiated()
    {
        self::expectException(\Error::class);

        new DateValueForTest(self::DATE);
    }

    /**
     * @group UnitTests
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
     * @group UnitTests
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
     * @group UnitTests
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
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \Exception
     */
    public function testEqualsFunction()
    {
        $integer = DateValueForTest::build(self::DATE);

        self::assertTrue($integer->equals(DateValueForTest::build(self::DATE)));
        self::assertFalse($integer->equals(DateValueForTest::build(self::DATE2)));
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \Exception
     */
    public function testDateCanBeCreatedWithTimezone()
    {
        $dateLocal = DateValueForTest::build(self::DATE, self::ASIA_SHANGHAI_TIMEZONE);
        $dateUtc = DateValueForTest::build(self::DATE, self::UTC_TIMEZONE);

        self::assertTrue($dateLocal->diffInHours($dateUtc) === self::ASIA_SHANGHAI_UTC_DIFF_HOURS);
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \Exception
     */
    public function testDateCanAddHours()
    {
        $dateUtc = DateValueForTest::build(self::DATE_WITH_TIMEZONE, self::UTC_TIMEZONE);
        $dateUtcPlusOne = DateValueForTest::build(self::DATE_WITH_TIMEZONE_PLUS_ONE, self::UTC_TIMEZONE);

        $dateToCompare = new \DateTime($dateUtc->value());
        $datePlusOne = new \DateTime($dateUtcPlusOne->value());

        self::assertTrue($datePlusOne->diff($dateToCompare)->h === 1);
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \Exception
     */
    public function testDateCanCompareDates()
    {
        $dateUtc = DateValueForTest::build(self::DATE_WITH_TIMEZONE, self::UTC_TIMEZONE);
        $dateUtcPlusOne = $dateUtc->addHours(2);

        $dateToCompare = new \DateTime($dateUtc->value());
        $datePlusOne = new \DateTime($dateUtcPlusOne->value());


        self::assertTrue($datePlusOne->diff($dateToCompare)->h === 2);
    }
}
