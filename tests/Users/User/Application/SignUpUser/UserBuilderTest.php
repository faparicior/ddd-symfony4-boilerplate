<?php declare(strict_types=1);

namespace App\Tests\Users\User\Application\SignUpUser;

use App\Users\User\Application\Service\UserBuilder;
use App\Users\User\Domain\ValueObject\Email;
use App\Users\User\Domain\ValueObject\Password;
use App\Users\User\Domain\ValueObject\UserId;
use App\Users\User\Domain\ValueObject\UserName;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserBuilderTest extends TestCase
{
    private const USER_UUID = '73f2791e-eaa7-4f81-a8cc-7cc601cda30e';
    private const USERNAME = 'Test User';
    private const EMAIL = 'test@test.de';
    private const PASSWORD = 'userpass';

    /**
     * @group Flats
     * @group Application
     */
    public function testUserCreatorCanCreateAnUser()
    {
        $user = UserBuilder::build(
            UserId::fromString(self::USER_UUID),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD)
        );

        self::assertEquals(self::USER_UUID, $user->userId()->value());
        self::assertEquals(self::USERNAME, $user->username()->value());
        self::assertEquals(self::EMAIL, $user->email()->value());
        self::assertEquals(self::PASSWORD, $user->password()->value());
    }
}
