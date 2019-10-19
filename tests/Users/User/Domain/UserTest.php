<?php declare(strict_types=1);

namespace App\Tests\Users\User\Domain;

use App\Users\User\Domain\User;
use App\Users\User\Domain\ValueObject\Email;
use App\Users\User\Domain\ValueObject\Password;
use App\Users\User\Domain\ValueObject\UserId;
use App\Users\User\Domain\ValueObject\UserName;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserTest extends TestCase
{
    private const USER_UUID = '73f2791e-eaa7-4f81-a8cc-7cc601cda30e';
    private const USERNAME = 'Test User';
    private const EMAIL = 'test@test.de';
    private const PASSWORD = 'userpass';

    /**
     * @group Flats
     * @group Domain
     */
    public function testUserCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new User();
    }

    /**
     * @group Flats
     * @group Domain
     */
    public function testUserCanBeBuilt()
    {
        /** @var User $user */
        $user = User::build(
            UserId::fromString(self::USER_UUID),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD)
        );

        self::assertInstanceOf(User::class, $user);
        self::assertEquals(self::USER_UUID, $user->userId()->value());
        self::assertEquals(self::USERNAME, $user->username()->value());
        self::assertEquals(self::EMAIL, $user->email()->value());
        self::assertEquals(self::PASSWORD, $user->password()->value());
    }

}
