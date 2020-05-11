<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Application\SignUpUser;

use App\Shared\Domain\Exceptions\DomainException;
use App\Users\User\Application\Service\UserBuilder;
use App\Users\User\Domain\Specifications\UserEmailIsUnique;
use App\Users\User\Domain\Specifications\UserNameIsUnique;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class UserBuilderTest extends TestCase
{
    private const USER_UUID = '73f2791e-eaa7-4f81-a8cc-7cc601cda30e';
    private const USERNAME = 'Test User';
    private const EMAIL = 'test@test.de';
    private const PASSWORD = 'userpass';

    private InMemoryUserRepository $userRepository;
    private UserBuilder $userBuilder;

    public function setUp()
    {
        parent::setUp();

        $this->userRepository = new InMemoryUserRepository();
        $this->userBuilder = new UserBuilder(
            $this->userRepository,
            UserSpecificationChain::build(...[
                UserNameIsUnique::build($this->userRepository),
                UserEmailIsUnique::build($this->userRepository),
            ])
        );
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Application
     *
     * @throws DomainException|ReflectionException
     */
    public function testUserBuilderCanCreateAnUser()
    {
        $user = $this->userBuilder->create(
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
}
