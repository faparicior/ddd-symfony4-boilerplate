<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain\Exceptions;

use App\Shared\Domain\Exceptions\InvalidEmailException;
use PHPUnit\Framework\TestCase;

class InvalidEmailExceptionTest extends TestCase
{
    private const TEST_MESSAGE = 'TestMessage';
    private const TEST_CODE = 2;
    private const INVALID_EMAIL_DEFAULT_MESSAGE = 'Invalid Email format';

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

        self::assertEquals(self::INVALID_EMAIL_DEFAULT_MESSAGE, $exception->getMessage());
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testInvalidEmailExceptionCanBeCreatedWithMessageAndStatusCode()
    {
        $exception = InvalidEmailException::build(self::TEST_MESSAGE, self::TEST_CODE);

        self::assertEquals(self::TEST_MESSAGE, $exception->getMessage());
        self::assertEquals(self::TEST_CODE, $exception->getCode());
    }
}
