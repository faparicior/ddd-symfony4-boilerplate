<?php declare(strict_types=1);

namespace App\Tests\Users\User\Domain\ValueObjects;

use App\Users\User\Domain\Exceptions\PasswordNotValidByPolicyRules;
use App\Users\User\Domain\ValueObjects\Password;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class PasswordTest extends TestCase
{
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
     */
    public function testPasswordCannotBeLessThanEightCharacters()
    {
        self::expectException(PasswordNotValidByPolicyRules::class);

        Password::build('1234567');
    }
}
