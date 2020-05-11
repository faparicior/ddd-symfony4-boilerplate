<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Domain\Specifications;

use App\Shared\Domain\Exceptions\DomainException;
use App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException;
use App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException;
use App\Users\User\Domain\Specifications\UserEmailIsUnique;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class UserEmailIsUniqueTest extends TestCase
{
    private const USERNAME = 'JohnDoe';
    private const USERNAME_NEW = 'JohnDoeNew';
    private const SPECIFICATION_FAIL_MESSAGE = 'User email is in use';

    private UserRepositoryInterface $userRepository;

    public function setUp()
    {
        parent::setUp();

        $this->userRepository = new InMemoryUserRepository();
    }

    public function testUserEmailExistsCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);
        new UserEmailIsUnique();
    }

    /**
     * @throws DomainException
     * @throws PasswordInvalidByPolicyRulesException
     * @throws UserNameInvalidByPolicyRulesException|ReflectionException
     */
    public function testUserEmailExistsReturnsTrueIfNotExistsInDatabase()
    {
        $user = User::build(
            UserId::build(),
            UserName::build(self::USERNAME),
            Email::build('test@test.de'),
            Password::build('123456789'),
            UserSpecificationChain::build(...[
                UserEmailIsUnique::build($this->userRepository),
            ])
        );

        $this->userRepository->create($user);

        $specification = UserEmailIsUnique::build($this->userRepository);

        $userNew = User::build(
            UserId::build(),
            UserName::build(self::USERNAME_NEW),
            Email::build('test2@test.de'),
            Password::build('123456789'),
            UserSpecificationChain::build(...[
                UserEmailIsUnique::build($this->userRepository),
            ])
        );

        self::assertTrue($specification->isSatisfiedBy($userNew));
    }

    /**
     * @throws DomainException
     * @throws PasswordInvalidByPolicyRulesException
     * @throws UserNameInvalidByPolicyRulesException|ReflectionException
     */
    public function testUserEmailExistsReturnsFalseIfExistsInDatabase()
    {
        $user = User::build(
            UserId::build(),
            UserName::build(self::USERNAME),
            Email::build('test@test.de'),
            Password::build('123456789'),
            UserSpecificationChain::build(...[
                UserEmailIsUnique::build($this->userRepository),
            ])
        );

        $this->userRepository->create($user);

        $specification = UserEmailIsUnique::build($this->userRepository);

        self::assertFalse($specification->isSatisfiedBy($user));
    }

    public function testUserEmailExistsReturnsExpectedFailedMessage()
    {
        $specification = UserEmailIsUnique::build($this->userRepository);
        self::assertEquals(self::SPECIFICATION_FAIL_MESSAGE, $specification->getFailedMessage());
    }
}
