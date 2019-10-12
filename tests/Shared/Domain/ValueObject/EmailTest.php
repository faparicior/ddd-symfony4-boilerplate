<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\InvalidEmailException;
use App\Shared\Domain\ValueObject\Email;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class EmailForTest extends Email
{

}

class EmailTest extends TestCase
{
    private const VALID_EMAIL = 'test@test.de';
    private const VALID_EMAIL_DIFFERENT = 'different@test.de';
    private const INVALID_EMAIL = 'test,@test.de';

    /**
     * @group Shared
     * @group Domain
     */
    public function testEmailCannotBeInstantiated()
    {
        self::expectException(\Error::class);
        new EmailForTest();
    }

    /**
     * @group Shared
     * @group Domain
     *
     * @throws InvalidEmailException
     */
    public function testEmailCanBeCreated()
    {
        $email = EmailForTest::build(self::VALID_EMAIL);

        self::assertInstanceOf(EmailForTest::class, $email);
    }

    /**
     * @group Shared
     * @group Domain
     *
     * @throws InvalidEmailException
     */
    public function testCreateEmailFailsForBadStringFormat()
    {
        self::expectException(InvalidEmailException::class);
        EmailForTest::build(self::INVALID_EMAIL);
    }

    /**
     * @group Shared
     * @group Domain
     *
     * @throws InvalidEmailException
     */
    public function testEmailStoresCorrectValue()
    {
        $email = EmailForTest::build(self::VALID_EMAIL);

        self::assertEquals(self::VALID_EMAIL, $email->value());
    }

    /**
     * @group Shared
     * @group Domain
     *
     * @throws InvalidEmailException
     */
    public function testEqualsFunction()
    {
        $integer = EmailForTest::build(self::VALID_EMAIL);

        self::assertTrue($integer->equals(EmailForTest::build(self::VALID_EMAIL)));
        self::assertFalse($integer->equals(EmailForTest::build(self::VALID_EMAIL_DIFFERENT)));
    }
}
