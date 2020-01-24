<?php declare(strict_types=1);

namespace App\Tests\Users\User\Domain\ValueObjects;

use App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException;
use App\Users\User\Domain\ValueObjects\Password;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    private const INVALID_PASSWORD_MESSAGE = "Password invalid by policy rules";

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testPasswordCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new Password();
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     *
     * @throws PasswordInvalidByPolicyRulesException
     */
    public function testPasswordCanBeBuilt()
    {
        $Password = Password::build('UserTest');

        self::assertInstanceOf(Password::class, $Password);
        self::assertEquals('UserTest', $Password->value());
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws PasswordInvalidByPolicyRulesException
     */
    public function testPasswordCannotBeLessThanEightCharacters()
    {
        self::expectException(PasswordInvalidByPolicyRulesException::class);
        self::expectExceptionMessage(self::INVALID_PASSWORD_MESSAGE);

        Password::build('1234567');
    }
}
