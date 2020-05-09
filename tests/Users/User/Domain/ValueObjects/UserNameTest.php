<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Domain\ValueObjects;

use App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException;
use App\Users\User\Domain\ValueObjects\UserName;
use PHPUnit\Framework\TestCase;

class UserNameTest extends TestCase
{
    private const INVALID_BY_POLICY_RULES = 'Username invalid by policy rules';

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testUserNameCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new UserName();
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testUserNameCanBeBuilt()
    {
        $userName = UserName::build('UserTest');

        self::assertInstanceOf(UserName::class, $userName);
        self::assertEquals('UserTest', $userName->value());
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testUserNameCanBeEmptyValue()
    {
        self::expectException(UserNameInvalidByPolicyRulesException::class);
        self::expectExceptionMessage(self::INVALID_BY_POLICY_RULES);

        UserName::build('');
    }
}
