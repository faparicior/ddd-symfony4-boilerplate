<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Application\Exceptions;

use App\Users\User\Application\Exceptions\UserInvalidException;
use PHPUnit\Framework\TestCase;

class UserInvalidExceptionTest extends TestCase
{
    private const TEST_MESSAGE = 'TestMessage';
    private const TEST_CODE = 2;
    private const INVALID_USER_DEFAULT_MESSAGE = 'User is not valid due to policy chain';

    public function testUserExistsExceptionExceptionCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new UserInvalidException();
    }

    public function testUserExistsExceptionCanBeCreatedWithDefaultMessage()
    {
        $exception = UserInvalidException::build();

        self::assertEquals(self::INVALID_USER_DEFAULT_MESSAGE, $exception->getMessage());
    }

    public function testUserExistsExceptionCanBeCreatedWithMessageAndStatusCode()
    {
        $exception = UserInvalidException::build(self::TEST_MESSAGE, self::TEST_CODE);

        self::assertEquals(self::TEST_MESSAGE, $exception->getMessage());
        self::assertEquals(self::TEST_CODE, $exception->getCode());
    }
}
