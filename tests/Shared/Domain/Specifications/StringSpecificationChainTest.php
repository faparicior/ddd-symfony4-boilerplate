<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\Specifications;

use App\Shared\Domain\Specifications\StringSpecificationChain;
use App\Shared\Domain\Specifications\StringSpecificationInterface;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class StringDummySpecification implements StringSpecificationInterface
{
    public function isSatisfiedBy(string $data): bool
    {
    }

    public function getFailedMessage(): string
    {
    }
}

class StringSpecificationOkStub implements StringSpecificationInterface
{
    public function isSatisfiedBy(string $data): bool
    {
        return true;
    }

    public function getFailedMessage(): string
    {
        return '';
    }
}

class StringSpecificationFailStub implements StringSpecificationInterface
{
    public function isSatisfiedBy(string $data): bool
    {
        return false;
    }

    public function getFailedMessage(): string
    {
        return 'String invalid using specifications';
    }
}
class StringSpecificationChainTest extends TestCase
{
    const STRING_SPECIFICATION_OK_STUB = 'StringSpecificationOkStub';
    const STRING_SPECIFICATION_FAIL_STUB = 'StringSpecificationFailStub';

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
        $specificationChain = StringSpecificationChain::build(...[(new StringDummySpecification())]);

        self::assertInstanceOf(StringSpecificationChain::class, $specificationChain);
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \ReflectionException
     */
    public function testStringSpecificationChainReturnFalseIfHasNoSpecifications()
    {
        $specificationChain = StringSpecificationChain::build();

        self::assertFalse($specificationChain->evalSpecifications(''));
    }


    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \ReflectionException
     */
    public function testStringSpecificationChainReturnTrueIfHasNoSpecifications()
    {
        $specificationChain = StringSpecificationChain::build(...[(new StringSpecificationOkStub())]);

        self::assertTrue($specificationChain->evalSpecifications(''));
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \ReflectionException
     */
    public function testStringSpecificationChainReturnSpecificationChainResults()
    {
        $specificationChain = StringSpecificationChain::build(...[(new StringSpecificationOkStub())]);

        self::assertTrue($specificationChain->evalSpecifications(''));
        $results = $specificationChain->getResults();

        self::assertArrayHasKey('' . self::STRING_SPECIFICATION_OK_STUB . '', $results);
        self::assertTrue($results[self::STRING_SPECIFICATION_OK_STUB]['value']);
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \ReflectionException
     */
    public function testStringSpecificationChainReturnFalseWithOneFailedSpecification()
    {
        $specificationChain = StringSpecificationChain::build(...[(new StringSpecificationOkStub()),(new StringSpecificationFailStub()) ]);
        self::assertFalse($specificationChain->evalSpecifications(''));

        $specificationChain = StringSpecificationChain::build(...[(new StringSpecificationFailStub()),(new StringSpecificationOkStub()) ]);
        self::assertFalse($specificationChain->evalSpecifications(''));
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \ReflectionException
     */
    public function testStringSpecificationChainReturnSpecificationChainFailedResults()
    {
        $specificationChain = StringSpecificationChain::build(...[(new StringSpecificationOkStub()),(new StringSpecificationFailStub()) ]);

        self::assertFalse($specificationChain->evalSpecifications(''));
        $results = $specificationChain->getResults();

        self::assertArrayHasKey('' . self::STRING_SPECIFICATION_OK_STUB . '', $results);
        self::assertArrayHasKey('' . self::STRING_SPECIFICATION_FAIL_STUB . '', $results);

        $resultsFail = $specificationChain->getFailedResults();

        self::assertEquals('String invalid using specifications', $resultsFail[self::STRING_SPECIFICATION_FAIL_STUB]);
    }
}
