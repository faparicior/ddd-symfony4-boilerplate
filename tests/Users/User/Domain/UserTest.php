<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Domain;

use App\Users\User\Domain\Exceptions\UserInvalidException;
use App\Users\User\Domain\Specifications\UserEmailIsUnique;
use App\Users\User\Domain\Specifications\UserIdIsUnique;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\Specifications\UserSpecificationInterface;
use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;

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

class UserTest extends TestCase
{
    private const USER_UUID = '73f2791e-eaa7-4f81-a8cc-7cc601cda30e';
    private const USERNAME = 'Test User';
    private const EMAIL = 'test@test.de';
    private const PASSWORD = 'userpass';

    private UserRepositoryInterface $userRepository;

    public function setUp()
    {
        parent::setUp();

        $this->userRepository = new InMemoryUserRepository();
    }

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
        $user = User::build(
            UserId::fromString(self::USER_UUID),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD),
            UserSpecificationChain::build(...[
                new UserSpecificationStub(),
            ])
        );

        self::assertInstanceOf(User::class, $user);
        self::assertEquals(self::USER_UUID, $user->userId()->value());
        self::assertEquals(self::USERNAME, $user->username()->value());
        self::assertEquals(self::EMAIL, $user->email()->value());
        self::assertEquals(self::PASSWORD, $user->password()->value());
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testUserCanReturnErrorWithSpecification()
    {
        self::expectException(UserInvalidException::class);
        self::expectExceptionMessage('User identification is in use, User email is in use');

        $user = User::build(
            UserId::fromString(self::USER_UUID),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD),
            UserSpecificationChain::build(...[
                new UserSpecificationStub(),
            ])
        );

        $this->userRepository->create($user);

        User::build(
            UserId::fromString(self::USER_UUID),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD),
            UserSpecificationChain::build(...[
                UserIdIsUnique::build($this->userRepository),
                UserEmailIsUnique::build($this->userRepository),
            ])
        );
    }
}
