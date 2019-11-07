<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\InvalidEmailException;
use App\Shared\Domain\ValueObjects\EmailValue;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class EmailValueForTest extends EmailValue
{

}

class EmailTest extends TestCase
{
    private const VALID_EMAIL = 'test@test.de';
    private const VALID_EMAIL_DIFFERENT = 'different@test.de';
    private const INVALID_EMAIL = 'test,@test.de';

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testEmailCannotBeInstantiated()
    {
        self::expectException(\Error::class);
        new EmailValueForTest();
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws InvalidEmailException
     */
    public function testEmailCanBeCreated()
    {
        $email = EmailValueForTest::build(self::VALID_EMAIL);

        self::assertInstanceOf(EmailValueForTest::class, $email);
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws InvalidEmailException
     */
    public function testCreateEmailFailsForBadStringFormat()
    {
        self::expectException(InvalidEmailException::class);
        EmailValueForTest::build(self::INVALID_EMAIL);
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws InvalidEmailException
     */
    public function testEmailStoresCorrectValue()
    {
        $email = EmailValueForTest::build(self::VALID_EMAIL);

        self::assertEquals(self::VALID_EMAIL, $email->value());
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws InvalidEmailException
     */
    public function testEqualsFunction()
    {
        $integer = EmailValueForTest::build(self::VALID_EMAIL);

        self::assertTrue($integer->equals(EmailValueForTest::build(self::VALID_EMAIL)));
        self::assertFalse($integer->equals(EmailValueForTest::build(self::VALID_EMAIL_DIFFERENT)));
    }
}
