<?php declare(strict_types=1);

namespace App\Tests\Users\User\Domain\Specifications;

use App\Users\User\Domain\Specifications\UserEmailIsUnique;
use App\Users\User\Domain\Specifications\UserNameIsUnique;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;

class UserNameIsUniqueTest extends TestCase
{
    const USERNAME = 'JohnDoe';
    const USERNAME_NEW = 'JohnDoeNew';

    /** @var UserRepositoryInterface */
    private $userRepository;

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
     * @throws \App\Shared\Domain\Exceptions\DomainException
     * @throws \App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException
     * @throws \App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException
     */
    public function testUsernameExistsReturnsTrueIfNotExistsInDatabase()
    {
        $user = User::build(
            UserId::build(),
            UserName::build(self::USERNAME),
            Email::build('test@test.de'),
            Password::build('123456789'),
            UserSpecificationChain::build(...[
                UserNameIsUnique::build($this->userRepository)
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
                UserNameIsUnique::build($this->userRepository)
            ])
        );

        self::assertTrue($specification->isSatisfiedBy($userNew));
    }


    /**
     * @throws \App\Shared\Domain\Exceptions\DomainException
     * @throws \App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException
     * @throws \App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException
     */
    public function testUsernameExistsReturnsFalseIfExistsInDatabase()
    {
        $user = User::build(
            UserId::build(),
            UserName::build(self::USERNAME),
            Email::build('test@test.de'),
            Password::build('123456789'),
            UserSpecificationChain::build(...[
                UserNameIsUnique::build($this->userRepository)
            ])
        );

        $this->userRepository->create($user);

        $userNew = User::build(
            UserId::build(),
            UserName::build(self::USERNAME),
            Email::build('test2@test.de'),
            Password::build('123456789'),
            UserSpecificationChain::build(...[
                UserEmailIsUnique::build($this->userRepository)
            ])
        );

        $specification = UserNameIsUnique::build($this->userRepository);

        self::assertFalse($specification->isSatisfiedBy($userNew));
    }
}
