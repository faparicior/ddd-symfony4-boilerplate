<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Application\Specifications;

use App\Shared\Domain\Exceptions\DomainException;
use App\Users\User\Application\Specifications\UserIdIsUnique;
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

class UserIdIsUniqueTest extends TestCase
{
    private const SPECIFICATION_FAIL_MESSAGE = 'User identification is in use';

    private UserRepositoryInterface $userRepository;

    public function setUp()
    {
        parent::setUp();

        $this->userRepository = new InMemoryUserRepository();
    }

    public function testUserIdExistsCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);
        new UserIdIsUnique();
    }

    /**
     * @throws DomainException
     * @throws PasswordInvalidByPolicyRulesException
     * @throws UserNameInvalidByPolicyRulesException|ReflectionException
     */
    public function testUserIdExistsReturnsTrueIfNotExistsInDatabase()
    {
        $user = User::build(
            UserId::build(),
            UserName::build('JohnDoe'),
            Email::build('test@test.de'),
            Password::build('123456789')
        );

        $this->userRepository->create($user);

        $userNew = User::build(
            UserId::build(),
            UserName::build('JohnDoe'),
            Email::build('test2@test.de'),
            Password::build('123456789')
        );

        $specification = UserIdIsUnique::build($this->userRepository);

        self::assertTrue($specification->isSatisfiedBy($userNew));
    }

    /**
     * @throws DomainException
     * @throws PasswordInvalidByPolicyRulesException
     * @throws UserNameInvalidByPolicyRulesException|ReflectionException
     */
    public function testUserIdExistsReturnsFalseIfExistsInDatabase()
    {
        $user = User::build(
            UserId::build(),
            UserName::build('JohnDoe'),
            Email::build('test@test.de'),
            Password::build('123456789')
        );

        $this->userRepository->create($user);

        $specification = UserIdIsUnique::build($this->userRepository);

        self::assertFalse($specification->isSatisfiedBy($user));
    }

    public function testUserIdExistsReturnsExpectedFailedMessage()
    {
        $specification = UserIdIsUnique::build($this->userRepository);

        self::assertEquals(self::SPECIFICATION_FAIL_MESSAGE, $specification->getFailedMessage());
    }
}
