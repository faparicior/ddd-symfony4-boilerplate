<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\Specifications;

use App\Shared\Domain\Specifications\DummySpecification;
use App\Shared\Domain\Specifications\SpecificationChain;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class SpecificationChainTest extends TestCase
{
    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testThatSpecificationChainCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new SpecificationChain();
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testThatSpecificationChainCanBeCreated()
    {
        $specificationChain = SpecificationChain::build(...[(new DummySpecification())]);
        self::assertInstanceOf(SpecificationChain::class, $specificationChain);
    }
}
