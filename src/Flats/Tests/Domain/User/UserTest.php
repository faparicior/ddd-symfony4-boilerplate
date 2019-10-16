<?php declare(strict_types=1);

namespace App\Flats\Tests\Domain\User;

use App\Flats\Domain\User\User;
use App\Flats\Domain\User\ValueObject\Email;
use App\Flats\Domain\User\ValueObject\Password;
use App\Flats\Domain\User\ValueObject\UserName;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserTest extends TestCase
{
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
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD)
        );

        self::assertInstanceOf(User::class, $user);
        self::assertEquals(self::USERNAME, $user->username()->value());
        self::assertEquals(self::EMAIL, $user->email()->value());
        self::assertEquals(self::PASSWORD, $user->password()->value());
    }

}
