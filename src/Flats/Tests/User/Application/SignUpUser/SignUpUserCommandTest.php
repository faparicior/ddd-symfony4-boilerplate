<?php declare(strict_types=1);

namespace App\Flats\Tests\User\Application\SignUpUser;

use App\Flats\User\Application\SignUpUser\SignUpUserCommand;
use App\Flats\User\Domain\ValueObject\Email;
use App\Flats\User\Domain\ValueObject\Password;
use App\Flats\User\Domain\ValueObject\UserName;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class SignUpUserCommandTest extends TestCase
{
    private const USERNAME = 'Test User';
    private const EMAIL = 'test@test.de';
    private const PASSWORD = 'userpass';

    /**
     * @group Flats
     * @group Application
     */
    public function testSignUpUserCommandCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new SignUpUserCommand();
    }

    /**
     * @group Flats
     * @group Application
     */
    public function testSignUpUserCommandCanBeBuilt()
    {
        $signUpUserCommand = SignUpUserCommand::build(
            self::USERNAME,
            self::EMAIL,
            self::PASSWORD
        );

        self::assertInstanceOf(SignUpUserCommand::class, $signUpUserCommand);
        self::assertEquals(self::USERNAME, $signUpUserCommand->username());
        self::assertEquals(self::EMAIL, $signUpUserCommand->email());
        self::assertEquals(self::PASSWORD, $signUpUserCommand->password());
    }
}
