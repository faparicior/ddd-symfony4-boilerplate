<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\InvalidEmailException;
use App\Shared\Domain\ValueObject\Email;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class EmailTest extends TestCase
{
    private const VALID_EMAIL = 'test@test.de';
    private const INVALID_EMAIL = 'test,@test.de';

    /**
     * @group Shared
     * @group Domain
     */
    public function testEmailCannotBeInstantiated()
    {
        self::expectException(\Error::class);
        new Email();
    }

    /**
     * @group Shared
     * @group Domain
     *
     * @throws InvalidEmailException
     */
    public function testEmailCanBeCreated()
    {
        $email = Email::build(self::VALID_EMAIL);

        self::assertInstanceOf(Email::class, $email);
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
        Email::build(self::INVALID_EMAIL);
    }

    /**
     * @group Shared
     * @group Domain
     *
     * @throws InvalidEmailException
     */
    public function testEmailStoresCorrectValue()
    {
        $email = Email::build(self::VALID_EMAIL);

        self::assertEquals(self::VALID_EMAIL, $email->value());
    }
}
