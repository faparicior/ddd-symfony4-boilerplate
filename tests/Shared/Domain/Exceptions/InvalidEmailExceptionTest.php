<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\Exceptions;

use App\Shared\Domain\Exceptions\InvalidEmailException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class InvalidEmailExceptionTest extends TestCase
{
    const TEST_MESSAGE = 'TestMessage';
    const TEST_CODE = 2;
    const INVALID_EMAIL_DEFAULT_MESSAGE = "Invalid Email format";

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testInvalidEmailExceptionCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new InvalidEmailException();
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testInvalidEmailExceptionCanBeCreatedWithDefaultMessage()
    {
        $exception = InvalidEmailException::build();

        self::assertEquals($exception->getMessage(), self::INVALID_EMAIL_DEFAULT_MESSAGE);
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testInvalidEmailExceptionCanBeCreatedWithMessageAndStatusCode()
    {
        $exception = InvalidEmailException::build(self::TEST_MESSAGE, self::TEST_CODE);

        self::assertEquals($exception->getMessage(), self::TEST_MESSAGE);
        self::assertEquals($exception->getCode(), self::TEST_CODE);
    }
}
