<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\DomainException;
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
    private const INVALID_EMAIL_MESSAGE = 'Invalid Email format';

    public function testEmailCannotBeInstantiated()
    {
        self::expectException(\Error::class);
        new EmailValueForTest();
    }

    /**
     * @throws InvalidEmailException
     * @throws DomainException
     */
    public function testEmailCanBeCreated()
    {
        $email = EmailValueForTest::build(self::VALID_EMAIL);

        self::assertInstanceOf(EmailValueForTest::class, $email);
    }

    /**
     * @throws InvalidEmailException
     * @throws DomainException
     */
    public function testCreateEmailFailsForBadStringFormatAndSendsCorrectMessage()
    {
        self::expectException(InvalidEmailException::class);
        self::expectExceptionMessage(self::INVALID_EMAIL_MESSAGE);
        EmailValueForTest::build(self::INVALID_EMAIL);
    }

    /**
     * @throws InvalidEmailException
     * @throws DomainException
     */
    public function testEmailStoresCorrectValue()
    {
        $email = EmailValueForTest::build(self::VALID_EMAIL);

        self::assertEquals(self::VALID_EMAIL, $email->value());
    }

    /**
     * @throws InvalidEmailException
     * @throws DomainException
     */
    public function testEqualsFunction()
    {
        $email = EmailValueForTest::build(self::VALID_EMAIL);

        self::assertTrue($email->equals(EmailValueForTest::build(self::VALID_EMAIL)));
        self::assertFalse($email->equals(EmailValueForTest::build(self::VALID_EMAIL_DIFFERENT)));
    }

    /**
     * @throws InvalidEmailException
     * @throws DomainException
     */
    public function testHasToStringMagicFunction()
    {
        $email = EmailValueForTest::build(self::VALID_EMAIL);

        self::assertEquals(self::VALID_EMAIL, $email->__toString());
    }
}
