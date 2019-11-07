<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\Specifications;

use App\Shared\Domain\Specifications\StringDummyStringSpecification;
use App\Shared\Domain\Specifications\StringSpecificationChain;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class StringSpecificationChainTest extends TestCase
{
    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testStringSpecificationChainCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new StringSpecificationChain();
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testStringSpecificationChainCanBeCreated()
    {
        $specificationChain = StringSpecificationChain::build(...[(new StringDummyStringSpecification())]);

        self::assertInstanceOf(StringSpecificationChain::class, $specificationChain);
    }
}
