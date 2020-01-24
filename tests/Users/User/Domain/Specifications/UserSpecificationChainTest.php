<?php declare(strict_types=1);

namespace App\Tests\Uses\User\Domain\Specifications;

use App\Users\User\Domain\Specifications\UserIdIsUnique;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\Specifications\UserSpecificationInterface;
use App\Users\User\Domain\User;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use PHPUnit\Framework\TestCase;

class UserSpecificationOkStub implements UserSpecificationInterface
{
    public function isSatisfiedBy(User $user): bool
    {
        return true;
    }

    public function getFailedMessage(): string
    {
        return '';
    }
}

class UserSpecificationFailStub implements UserSpecificationInterface
{
    public function isSatisfiedBy(User $user): bool
    {
        return false;
    }

    public function getFailedMessage(): string
    {
        return 'User identification is in use';
    }
}

class UserSpecificationChainTest extends TestCase
{
    private const USER_UUID = '73f2791e-eaa7-4f81-a8cc-7cc601cda30e';
    private const USERNAME = 'Test User';
    private const EMAIL = 'test@test.de';
    private const PASSWORD = 'userpass';

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    const USER_SPECIFICATION_OK_STUB = 'UserSpecificationOkStub';
    const USER_SPECIFICATION_FAIL_STUB = 'UserSpecificationFailStub';

    public function testUserSpecificationChainCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new UserSpecificationChain();
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testUserSpecificationChainCanBeCreated()
    {
        $specificationChain = UserSpecificationChain::build(...[(new UserSpecificationOkStub())]);

        self::assertInstanceOf(UserSpecificationChain::class, $specificationChain);
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \App\Shared\Domain\Exceptions\DomainException
     * @throws \App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException
     * @throws \App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException
     * @throws \ReflectionException
     */
    public function testUserSpecificationChainReturnFalseIfHasNoSpecifications()
    {
        /** @var User $user */
        $user = User::build(
            UserId::fromString(self::USER_UUID),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD),
            UserSpecificationChain::build(...[
                new UserSpecificationOkStub()
            ])
        );

        $specificationChain = UserSpecificationChain::build();

        self::assertFalse($specificationChain->evalSpecifications($user));
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \App\Shared\Domain\Exceptions\DomainException
     * @throws \App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException
     * @throws \App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException
     * @throws \ReflectionException
     */
    public function testUserSpecificationChainReturnTrueIfHasSpecifications()
    {
        /** @var User $user */
        $user = User::build(
            UserId::fromString(self::USER_UUID),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD),
            UserSpecificationChain::build(...[
                new UserSpecificationOkStub()
            ])
        );

        $specificationChain = UserSpecificationChain::build(new UserSpecificationOkStub());

        self::assertTrue($specificationChain->evalSpecifications($user));
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \App\Shared\Domain\Exceptions\DomainException
     * @throws \App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException
     * @throws \App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException
     * @throws \ReflectionException
     */
    public function testUserSpecificationChainReturnSpecificationChainResults()
    {
        /** @var User $user */
        $user = User::build(
            UserId::fromString(self::USER_UUID),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD),
            UserSpecificationChain::build(...[
                new UserSpecificationOkStub()
            ])
        );

        $specificationChain = UserSpecificationChain::build(new UserSpecificationOkStub());

        $specificationChain->evalSpecifications($user);

        $results = $specificationChain->getResults();

        self::assertArrayHasKey('' . self::USER_SPECIFICATION_OK_STUB . '', $results);
        self::assertTrue($results[self::USER_SPECIFICATION_OK_STUB]['value']);
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \App\Shared\Domain\Exceptions\DomainException
     * @throws \App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException
     * @throws \App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException
     * @throws \ReflectionException
     */
    public function testUserSpecificationChainReturnSpecificationFailedResults()
    {
        /** @var User $user */
        $user = User::build(
            UserId::fromString(self::USER_UUID),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD),
            UserSpecificationChain::build(...[
                new UserSpecificationOkStub()
            ])
        );

        $specificationChain = UserSpecificationChain::build(new UserSpecificationOkStub(), new UserSpecificationFailStub());

        $specificationChain->evalSpecifications($user);

        $results = $specificationChain->getResults();

        self::assertArrayHasKey('' . self::USER_SPECIFICATION_OK_STUB . '', $results);
        self::assertArrayHasKey('' . self::USER_SPECIFICATION_FAIL_STUB . '', $results);

        $resultsFail = $specificationChain->getFailedResults();

        self::assertEquals(UserIdIsUnique::SPECIFICATION_FAIL_MESSAGE, $resultsFail[self::USER_SPECIFICATION_FAIL_STUB]);
    }
}
