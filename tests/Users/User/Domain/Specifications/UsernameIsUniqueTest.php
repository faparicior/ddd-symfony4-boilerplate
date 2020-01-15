<?php declare(strict_types=1);

namespace App\Tests\Users\User\Domain\Specifications;

use App\Users\User\Domain\Specifications\UserNameIsUnique;
use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UsernameIsUniqueTest extends TestCase
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
     * @throws \App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRules
     * @throws \App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRules
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

        $specification = UserNameIsUnique::build($this->userRepository);

        $userNew = User::build(
            UserId::build(),
            UserName::build(self::USERNAME_NEW),
            Email::build('test@test.de'),
            Password::build('123456789')
        );

        self::assertTrue($specification->isSatisfiedBy($userNew));
    }


    /**
     * @throws \App\Shared\Domain\Exceptions\DomainException
     * @throws \App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRules
     * @throws \App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRules
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

        $specification = UserNameIsUnique::build($this->userRepository);

        self::assertFalse($specification->isSatisfiedBy($user));
    }
}
