<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Domain\Exceptions;

use App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException;
use PHPUnit\Framework\TestCase;

class UserNameInvalidByPolicyRulesTest extends TestCase
{
    private const TEST_MESSAGE = 'TestMessage';
    private const TEST_CODE = 2;
    private const INVALID_PASSWORD_DEFAULT_MESSAGE = 'Username is not valid by policy rules';

    public function testPasswordInvalidByPolicyRulesExceptionCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new UserNameInvalidByPolicyRulesException();
    }

    public function testPasswordInvalidByPolicyRulesExceptionCanBeCreatedWithDefaultMessage()
    {
        $exception = UserNameInvalidByPolicyRulesException::build();

        self::assertEquals($exception->getMessage(), self::INVALID_PASSWORD_DEFAULT_MESSAGE);
    }

    public function testPasswordInvalidByPolicyRulesExceptionCanBeCreatedWithMessageAndStatusCode()
    {
        $exception = UserNameInvalidByPolicyRulesException::build(self::TEST_MESSAGE, self::TEST_CODE);

        self::assertEquals(self::TEST_MESSAGE, $exception->getMessage());
        self::assertEquals(self::TEST_CODE, $exception->getCode());
    }
}
