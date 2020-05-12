<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Application\Specifications;

use App\Shared\Domain\Exceptions\DomainException;
use App\Shared\Domain\Exceptions\InvalidEmailException;
use App\Users\User\Application\Specifications\CreateUserSpecificationChain;
use App\Users\User\Application\Specifications\UserIdIsUnique;
use App\Users\User\Application\Specifications\UserSpecificationInterface;
use App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException;
use App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException;
use App\Users\User\Domain\User;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use PHPUnit\Framework\TestCase;
use ReflectionException;

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

class CreateUserSpecificationChainTest extends TestCase
{
    private const USER_UUID = '73f2791e-eaa7-4f81-a8cc-7cc601cda30e';
    private const USERNAME = 'Test User';
    private const EMAIL = 'test@test.de';
    private const PASSWORD = 'userpass';

    private const USER_SPECIFICATION_OK_STUB = 'UserSpecificationOkStub';
    private const USER_SPECIFICATION_FAIL_STUB = 'UserSpecificationFailStub';

    private User $user;

    /**
     * @throws DomainException
     * @throws PasswordInvalidByPolicyRulesException
     * @throws ReflectionException
     * @throws UserNameInvalidByPolicyRulesException
     * @throws InvalidEmailException
     */
    public function setUp()
    {
        parent::setUp();

        $this->user = User::build(
            UserId::fromString(self::USER_UUID),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD)
        );
    }

    public function testCreateUserSpecificationChainCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new CreateUserSpecificationChain();
    }

    public function testCreateUserSpecificationChainCanBeCreated()
    {
        $specificationChain = CreateUserSpecificationChain::build(...[(new UserSpecificationOkStub())]);

        self::assertInstanceOf(CreateUserSpecificationChain::class, $specificationChain);
    }

    /**
     * @throws ReflectionException
     */
    public function testCreateUserSpecificationChainReturnFalseIfHasNoSpecifications()
    {
        $specificationChain = CreateUserSpecificationChain::build();

        self::assertFalse($specificationChain->evalSpecifications($this->user));
    }

    /**
     * @throws ReflectionException
     */
    public function testCreateUserSpecificationChainReturnTrueIfHasSpecifications()
    {
        $specificationChain = CreateUserSpecificationChain::build(...[new UserSpecificationOkStub()]);

        self::assertTrue($specificationChain->evalSpecifications($this->user));
    }

    /**
     * @throws ReflectionException
     */
    public function testCreateUserSpecificationChainReturnSpecificationChainResults()
    {
        $specificationChain = CreateUserSpecificationChain::build(new UserSpecificationOkStub());
        $specificationChain->evalSpecifications($this->user);
        $results = $specificationChain->getResults();

        self::assertArrayHasKey(''.self::USER_SPECIFICATION_OK_STUB.'', $results);
        self::assertTrue($results[self::USER_SPECIFICATION_OK_STUB]['value']);
    }

    /**
     * @throws ReflectionException
     */
    public function testCreateUserSpecificationChainReturnSpecificationFailedResults()
    {
        $specificationChain = CreateUserSpecificationChain::build(new UserSpecificationOkStub(), new UserSpecificationFailStub());
        $specificationChain->evalSpecifications($this->user);
        $results = $specificationChain->getResults();

        self::assertArrayHasKey(''.self::USER_SPECIFICATION_OK_STUB.'', $results);
        self::assertArrayHasKey(''.self::USER_SPECIFICATION_FAIL_STUB.'', $results);

        $resultsFail = $specificationChain->getFailedResults();

        self::assertEquals(UserIdIsUnique::SPECIFICATION_FAIL_MESSAGE, $resultsFail[self::USER_SPECIFICATION_FAIL_STUB]);
    }
}
