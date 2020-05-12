<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\DateValue;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class DateValueForTest extends DateValue
{
}

class DateValueTest extends TestCase
{
    private const DATE = '2018-01-01';
    private const DATE_DIFFERENT = '2018-01-02';
    private const DATE_WITH_TIMEZONE = '2018-02-01T00:00:00.000000Z';
    private const DATE_WITH_TIMEZONE_PLUS_ONE = '2018-02-01T01:00:00.000000Z';
    private const DATE2 = '2018-02-01';

    private const UTC_TIMEZONE = 'UTC';
    private const ASIA_SHANGHAI_TIMEZONE = 'Asia/Shanghai';
    private const ASIA_SHANGHAI_UTC_DIFF_HOURS = 8;

    public function testDateCannotBeInstantiated()
    {
        self::expectException(\Error::class);

        new DateValueForTest(self::DATE);
    }

    /**
     * @throws Exception
     */
    public function testDateCanBeCreated()
    {
        $date = DateValueForTest::build(self::DATE);

        self::assertInstanceOf(DateValue::class, $date);
    }

    /**
     * @throws Exception
     */
    public function testCreateDateFailsForBadStringFormat()
    {
        self::expectException(Exception::class);
        DateValueForTest::build('2018-15-32');
    }

    /**
     * @throws Exception
     */
    public function testDateStoresCorrectValue()
    {
        $date = DateValueForTest::build(self::DATE2);

        self::assertEquals(self::DATE_WITH_TIMEZONE, $date->value());
    }

    /**
     * @throws Exception
     */
    public function testEqualsFunction()
    {
        $integer = DateValueForTest::build(self::DATE);

        self::assertTrue($integer->equals(DateValueForTest::build(self::DATE)));
        self::assertFalse($integer->equals(DateValueForTest::build(self::DATE2)));
    }

    /**
     * @throws Exception
     */
    public function testDateCanBeCreatedWithTimezone()
    {
        $dateLocal = DateValueForTest::build(self::DATE, self::ASIA_SHANGHAI_TIMEZONE);
        $dateUtc = DateValueForTest::build(self::DATE, self::UTC_TIMEZONE);

        self::assertTrue(self::ASIA_SHANGHAI_UTC_DIFF_HOURS === $dateLocal->diffInHours($dateUtc));
    }

    /**
     * @throws Exception
     */
    public function testDateCanAddHours()
    {
        $dateUtc = DateValueForTest::build(self::DATE_WITH_TIMEZONE, self::UTC_TIMEZONE);
        $dateUtcPlusOne = DateValueForTest::build(self::DATE_WITH_TIMEZONE_PLUS_ONE, self::UTC_TIMEZONE);

        $dateToCompare = new DateTime($dateUtc->value());
        $datePlusOne = new DateTime($dateUtcPlusOne->value());

        self::assertTrue(1 === $datePlusOne->diff($dateToCompare)->h);
    }

    /**
     * @throws Exception
     */
    public function testDateCanCompareDates()
    {
        $dateUtc = DateValueForTest::build(self::DATE_WITH_TIMEZONE, self::UTC_TIMEZONE);
        $dateUtcPlusOne = $dateUtc->addHours(2);

        $dateToCompare = new DateTime($dateUtc->value());
        $datePlusOne = new DateTime($dateUtcPlusOne->value());

        self::assertTrue(2 === $datePlusOne->diff($dateToCompare)->h);
    }
}
