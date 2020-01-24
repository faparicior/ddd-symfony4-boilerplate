<?php declare(strict_types=1);

namespace App\Tests\Users\User\Domain\Exceptions;

use App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException;
use PHPUnit\Framework\TestCase;

class PasswordInvalidByPolicyRulesTest extends TestCase
{
    const TEST_MESSAGE = 'TestMessage';
    const TEST_CODE = 2;
    const INVALID_PASSWORD_DEFAULT_MESSAGE = "Password invalid by policy rules";

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testPasswordInvalidByPolicyRulesExceptionCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new PasswordInvalidByPolicyRulesException();
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testPasswordInvalidByPolicyRulesExceptionCanBeCreatedWithDefaultMessage()
    {
        $exception = PasswordInvalidByPolicyRulesException::build();

        self::assertEquals($exception->getMessage(), self::INVALID_PASSWORD_DEFAULT_MESSAGE);
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testPasswordInvalidByPolicyRulesExceptionCanBeCreatedWithMessageAndStatusCode()
    {
        $exception = PasswordInvalidByPolicyRulesException::build(self::TEST_MESSAGE, self::TEST_CODE);

        self::assertEquals($exception->getMessage(), self::TEST_MESSAGE);
        self::assertEquals($exception->getCode(), self::TEST_CODE);
    }
}
