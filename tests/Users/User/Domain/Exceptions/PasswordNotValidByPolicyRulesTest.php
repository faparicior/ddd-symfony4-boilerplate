<?php declare(strict_types=1);

namespace App\Tests\Users\User\Domain\Exceptions;

use App\Users\User\Domain\Exceptions\PasswordNotValidByPolicyRules;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class PasswordNotValidByPolicyRulesTest extends TestCase
{
    const TEST_MESSAGE = 'TestMessage';
    const TEST_CODE = 2;

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testPasswordNotValidByPolicyRulesExceptionCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new PasswordNotValidByPolicyRules();
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testPasswordNotValidByPolicyRulesExceptionCanBeCreatedWithMessageAndStatusCode()
    {
        $exception = PasswordNotValidByPolicyRules::build(self::TEST_MESSAGE, self::TEST_CODE);

        self::assertEquals($exception->getMessage(), self::TEST_MESSAGE);
        self::assertEquals($exception->getCode(), self::TEST_CODE);
    }
}
