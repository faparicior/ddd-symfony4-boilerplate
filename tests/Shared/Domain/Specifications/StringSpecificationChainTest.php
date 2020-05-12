<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain\Specifications;

use App\Shared\Domain\Specifications\StringSpecificationChain;
use App\Shared\Domain\Specifications\StringSpecificationInterface;
use PHPUnit\Framework\TestCase;
use ReflectionException;

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
    private const STRING_SPECIFICATION_OK_STUB = 'StringSpecificationOkStub';
    private const STRING_SPECIFICATION_FAIL_STUB = 'StringSpecificationFailStub';

    public function testStringSpecificationChainCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new StringSpecificationChain();
    }

    public function testStringSpecificationChainCanBeCreated()
    {
        $specificationChain = StringSpecificationChain::build(...[(new StringDummySpecification())]);

        self::assertInstanceOf(StringSpecificationChain::class, $specificationChain);
    }

    /**
     * @throws ReflectionException
     */
    public function testStringSpecificationChainReturnFalseIfHasNoSpecifications()
    {
        $specificationChain = StringSpecificationChain::build();

        self::assertFalse($specificationChain->evalSpecifications(''));
    }

    /**
     * @throws ReflectionException
     */
    public function testStringSpecificationChainReturnTrueIfHasNoSpecifications()
    {
        $specificationChain = StringSpecificationChain::build(...[(new StringSpecificationOkStub())]);

        self::assertTrue($specificationChain->evalSpecifications(''));
    }

    /**
     * @throws ReflectionException
     */
    public function testStringSpecificationChainReturnSpecificationChainResults()
    {
        $specificationChain = StringSpecificationChain::build(...[(new StringSpecificationOkStub())]);

        self::assertTrue($specificationChain->evalSpecifications(''));
        $results = $specificationChain->getResults();

        self::assertArrayHasKey(''.self::STRING_SPECIFICATION_OK_STUB.'', $results);
        self::assertTrue($results[self::STRING_SPECIFICATION_OK_STUB]['value']);
    }

    /**
     * @throws ReflectionException
     */
    public function testStringSpecificationChainReturnFalseWithOneFailedSpecification()
    {
        $specificationChain = StringSpecificationChain::build(...[(new StringSpecificationOkStub()), (new StringSpecificationFailStub())]);
        self::assertFalse($specificationChain->evalSpecifications(''));

        $specificationChain = StringSpecificationChain::build(...[(new StringSpecificationFailStub()), (new StringSpecificationOkStub())]);
        self::assertFalse($specificationChain->evalSpecifications(''));
    }

    /**
     * @throws ReflectionException
     */
    public function testStringSpecificationChainReturnSpecificationChainFailedResults()
    {
        $specificationChain = StringSpecificationChain::build(...[(new StringSpecificationOkStub()), (new StringSpecificationFailStub())]);

        self::assertFalse($specificationChain->evalSpecifications(''));
        $results = $specificationChain->getResults();

        self::assertArrayHasKey(''.self::STRING_SPECIFICATION_OK_STUB.'', $results);
        self::assertArrayHasKey(''.self::STRING_SPECIFICATION_FAIL_STUB.'', $results);

        $resultsFail = $specificationChain->getFailedResults();

        self::assertEquals('String invalid using specifications', $resultsFail[self::STRING_SPECIFICATION_FAIL_STUB]);
    }
}
