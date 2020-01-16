<?php declare(strict_types=1);

namespace App\Tests\Uses\User\Domain\Specifications;

use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\Specifications\UserSpecificationInterface;
use App\Users\User\Domain\User;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserSpecificationStub implements UserSpecificationInterface
{
    public function isSatisfiedBy(User $user): bool
    {
        return true;
    }
}

class UserSpecificationChainTest extends TestCase
{
    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testStringSpecificationChainCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new UserSpecificationChain();
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testStringSpecificationChainCanBeCreated()
    {
        $specificationChain = UserSpecificationChain::build(...[(new UserSpecificationStub())]);

        self::assertInstanceOf(UserSpecificationChain::class, $specificationChain);
    }
}
