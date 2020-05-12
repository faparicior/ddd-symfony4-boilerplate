<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Application\Services;

use App\Shared\Domain\Exceptions\DomainException;
use App\Shared\Domain\Exceptions\InvalidEmailException;
use App\Users\User\Application\Exceptions\UserInvalidException;
use App\Users\User\Application\Service\UserCreator;
use App\Users\User\Application\Specifications\CreateUserSpecificationChain;
use App\Users\User\Application\Specifications\UserEmailIsUnique;
use App\Users\User\Application\Specifications\UserNameIsUnique;
use App\Users\User\Application\Specifications\UserSpecificationInterface;
use App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException;
use App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException;
use App\Users\User\Domain\User;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class UserSpecificationStub implements UserSpecificationInterface
{
    public function isSatisfiedBy(User $user): bool
    {
        return true;
    }

    public function getFailedMessage(): string
    {
        // TODO: Implement getFailedMessage() method.
    }
}

class UserCreatorTest extends TestCase
{
    private const USER_UUID = '73f2791e-eaa7-4f81-a8cc-7cc601cda30e';
    private const USERNAME = 'Test User';
    private const EMAIL = 'test@test.de';
    private const PASSWORD = 'userpass';

    private UserCreator $userCreator;

    public function setUp()
    {
        parent::setUp();

        $userRepository = new InMemoryUserRepository();
        $this->userCreator = new UserCreator(
            $userRepository,
            CreateUserSpecificationChain::build(...[
                UserNameIsUnique::build($userRepository),
                UserEmailIsUnique::build($userRepository),
            ])
        );
    }

    /**
     * @throws DomainException
     * @throws InvalidEmailException
     * @throws PasswordInvalidByPolicyRulesException
     * @throws ReflectionException
     * @throws UserInvalidException
     * @throws UserNameInvalidByPolicyRulesException
     */
    public function testUserCreatorCanCreateAnUser()
    {
        $user = $this->userCreator->create(
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

    /**
     * @throws DomainException
     * @throws ReflectionException
     * @throws UserInvalidException
     * @throws InvalidEmailException
     * @throws PasswordInvalidByPolicyRulesException
     * @throws UserNameInvalidByPolicyRulesException
     */
    public function testUserCanReturnErrorWithSpecification()
    {
        self::expectException(UserInvalidException::class);
        self::expectExceptionMessage('Username is in use, User email is in use');

        $user = $this->userCreator->create(
            UserId::fromString(self::USER_UUID),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD)
        );

        $secondUser = $this->userCreator->create(
            UserId::fromString(self::USER_UUID),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD)
        );
    }
}
