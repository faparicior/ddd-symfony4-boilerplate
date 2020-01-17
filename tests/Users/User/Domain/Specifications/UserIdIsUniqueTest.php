<?php declare(strict_types=1);

namespace App\Tests\Users\User\Domain\Specifications;

use App\Users\User\Domain\Specifications\UserEmailIsUnique;
use App\Users\User\Domain\Specifications\UserIdIsUnique;
use App\Users\User\Domain\Specifications\UserNameIsUnique;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserIdIsUniqueTest extends TestCase
{

    /** @var UserRepositoryInterface */
    private $userRepository;

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
     * @throws \App\Shared\Domain\Exceptions\DomainException
     * @throws \App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRules
     * @throws \App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRules
     */
    public function testUserIdExistsReturnsTrueIfNotExistsInDatabase()
    {
        $user = User::build(
            UserId::build(),
            UserName::build('JohnDoe'),
            Email::build('test@test.de'),
            Password::build('123456789'),
            UserSpecificationChain::build(...[
                UserIdIsUnique::build($this->userRepository)
            ])
        );

        $this->userRepository->create($user);

        $userNew = User::build(
            UserId::build(),
            UserName::build('JohnDoe'),
            Email::build('test2@test.de'),
            Password::build('123456789'),
            UserSpecificationChain::build(...[
                UserEmailIsUnique::build($this->userRepository)
            ])
        );

        $specification = UserIdIsUnique::build($this->userRepository);

        self::assertTrue($specification->isSatisfiedBy($userNew));
    }


    /**
     * @throws \App\Shared\Domain\Exceptions\DomainException
     * @throws \App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRules
     * @throws \App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRules
     */
    public function testUserIdExistsReturnsFalseIfExistsInDatabase()
    {
        $user = User::build(
            UserId::build(),
            UserName::build('JohnDoe'),
            Email::build('test@test.de'),
            Password::build('123456789'),
            UserSpecificationChain::build(...[
                UserIdIsUnique::build($this->userRepository)
            ])
        );

        $this->userRepository->create($user);

        $specification = UserIdIsUnique::build($this->userRepository);

        self::assertFalse($specification->isSatisfiedBy($user));
    }
}
