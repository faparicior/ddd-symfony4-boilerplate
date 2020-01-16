<?php declare(strict_types=1);

namespace App\Tests\Users\User\Domain;

use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\Specifications\UserSpecificationInterface;
use App\Users\User\Domain\User;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserSpecificationStub implements UserSpecificationInterface
{
    public function isSatisfiedBy(User $user): bool
    {
        return true;
    }
}

class UserTest extends TestCase
{
    private const USER_UUID = '73f2791e-eaa7-4f81-a8cc-7cc601cda30e';
    private const USERNAME = 'Test User';
    private const EMAIL = 'test@test.de';
    private const PASSWORD = 'userpass';

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testUserCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new User();
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testUserCanBeBuilt()
    {
        /** @var User $user */
        $user = User::build(
            UserId::fromString(self::USER_UUID),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD),
            UserSpecificationChain::build(...[
                new UserSpecificationStub()
            ])
        );

        self::assertInstanceOf(User::class, $user);
        self::assertEquals(self::USER_UUID, $user->userId()->value());
        self::assertEquals(self::USERNAME, $user->username()->value());
        self::assertEquals(self::EMAIL, $user->email()->value());
        self::assertEquals(self::PASSWORD, $user->password()->value());
    }

}
