<?php declare(strict_types=1);

namespace App\Tests\Users\User\Domain\Exceptions;

use App\Users\User\Domain\Exceptions\UserExistsException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserExistsExceptionTest extends TestCase
{
    const TEST_MESSAGE = 'TestMessage';
    const TEST_CODE = 2;
    const INVALID_USER_DEFAULT_MESSAGE = "Username, Id or email is in use";

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testUserExistsExceptionExceptionCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new UserExistsException();
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testUserExistsExceptionCanBeCreatedWithDefaultMessage()
    {
        $exception = UserExistsException::build();

        self::assertEquals($exception->getMessage(), self::INVALID_USER_DEFAULT_MESSAGE);
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testUserExistsExceptionCanBeCreatedWithMessageAndStatusCode()
    {
        $exception = UserExistsException::build(self::TEST_MESSAGE, self::TEST_CODE);

        self::assertEquals($exception->getMessage(), self::TEST_MESSAGE);
        self::assertEquals($exception->getCode(), self::TEST_CODE);
    }
}
