<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Application\Exceptions;

use App\Users\User\Application\Exceptions\UserNotFoundException;
use PHPUnit\Framework\TestCase;

class UserNotFoundExceptionTest extends TestCase
{
    private const USER_NOT_FOUND_MESSAGE = 'User not found';

    public function testUserNotFoundExceptionCannotBeInstantiated()
    {
        self::expectException(\Error::class);

        new UserNotFoundException();
    }

    public function testUserNotFoundExceptionCanBeBuilt()
    {
        $applicationException = UserNotFoundException::build();
        self::assertEquals(self::USER_NOT_FOUND_MESSAGE, $applicationException->getMessage());
    }
}
