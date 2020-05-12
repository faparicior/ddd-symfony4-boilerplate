<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Application\Specifications;

use App\Shared\Domain\Exceptions\DomainException;
use App\Users\User\Application\Specifications\UserEmailIsUnique;
use App\Users\User\Application\Specifications\UserNameIsUnique;
use App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException;
use App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException;
use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class UserNameIsUniqueTest extends TestCase
{
    private const SPECIFICATION_FAIL_MESSAGE = 'Username is in use';

    private const USERNAME = 'JohnDoe';
    private const USERNAME_NEW = 'JohnDoeNew';

    private UserRepositoryInterface $userRepository;

    public function setUp()
    {
        parent::setUp();

        $this->userRepository = new InMemoryUserRepository();
    }

    public function testUsernameExistsCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);
        new UserNameIsUnique();
    }

    /**
     * @throws DomainException
     * @throws PasswordInvalidByPolicyRulesException
     * @throws UserNameInvalidByPolicyRulesException
     */
    public function testUsernameExistsReturnsTrueIfNotExistsInDatabase()
    {
        $user = User::build(
            UserId::build(),
            UserName::build(self::USERNAME),
            Email::build('test@test.de'),
            Password::build('123456789')
        );

        $this->userRepository->create($user);

        $specification = UserEmailIsUnique::build($this->userRepository);

        $userNew = User::build(
            UserId::build(),
            UserName::build(self::USERNAME_NEW),
            Email::build('test2@test.de'),
            Password::build('123456789')
        );

        self::assertTrue($specification->isSatisfiedBy($userNew));
    }

    /**
     * @throws DomainException
     * @throws PasswordInvalidByPolicyRulesException
     * @throws UserNameInvalidByPolicyRulesException|ReflectionException
     */
    public function testUsernameExistsReturnsFalseIfExistsInDatabase()
    {
        $user = User::build(
            UserId::build(),
            UserName::build(self::USERNAME),
            Email::build('test@test.de'),
            Password::build('123456789')
        );

        $this->userRepository->create($user);

        $userNew = User::build(
            UserId::build(),
            UserName::build(self::USERNAME),
            Email::build('test2@test.de'),
            Password::build('123456789')
        );

        $specification = UserNameIsUnique::build($this->userRepository);

        self::assertFalse($specification->isSatisfiedBy($userNew));
    }

    public function testUsernameExistsReturnsExpectedFailedMessage()
    {
        $specification = UserNameIsUnique::build($this->userRepository);
        self::assertEquals(self::SPECIFICATION_FAIL_MESSAGE, $specification->getFailedMessage());
    }
}
