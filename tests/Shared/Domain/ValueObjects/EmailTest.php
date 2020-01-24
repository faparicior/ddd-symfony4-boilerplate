<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\InvalidEmailException;
use App\Shared\Domain\ValueObjects\EmailValue;
use PHPUnit\Framework\TestCase;

class EmailValueForTest extends EmailValue
{

}

class EmailTest extends TestCase
{
    private const VALID_EMAIL = 'test@test.de';
    private const VALID_EMAIL_DIFFERENT = 'different@test.de';
    private const INVALID_EMAIL = 'test,@test.de';
    private const INVALID_EMAIL_MESSAGE = "Invalid Email format";

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
     * @throws \App\Shared\Domain\Exceptions\DomainException
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
     * @throws \App\Shared\Domain\Exceptions\DomainException
     */
    public function testCreateEmailFailsForBadStringFormatAndSendsCorrectMessage()
    {
        self::expectException(InvalidEmailException::class);
        self::expectExceptionMessage(self::INVALID_EMAIL_MESSAGE);
        EmailValueForTest::build(self::INVALID_EMAIL);
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws InvalidEmailException
     * @throws \App\Shared\Domain\Exceptions\DomainException
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
     * @throws \App\Shared\Domain\Exceptions\DomainException
     */
    public function testEqualsFunction()
    {
        $email = EmailValueForTest::build(self::VALID_EMAIL);

        self::assertTrue($email->equals(EmailValueForTest::build(self::VALID_EMAIL)));
        self::assertFalse($email->equals(EmailValueForTest::build(self::VALID_EMAIL_DIFFERENT)));
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws InvalidEmailException
     * @throws \App\Shared\Domain\Exceptions\DomainException
     */
    public function testHasToStringMagicFunction()
    {
        $email = EmailValueForTest::build(self::VALID_EMAIL);

        self::assertEquals(self::VALID_EMAIL, $email->__toString());
    }
}
