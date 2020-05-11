<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;
use PHPUnit\Framework\TestCase;

class DomainExceptionForTest extends DomainException
{
}

class DomainExceptionTest extends TestCase
{
    private const TEST_MESSAGE = 'TestMessage';
    private const TEST_CODE = 2;

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testExceptionCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new DomainExceptionForTest();
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testExceptionCanBeBuilt()
    {
        $exception = DomainExceptionForTest::build();

        self::assertInstanceOf(DomainExceptionForTest::class, $exception);
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testExceptionCanBeCreatedWithMessageAndStatusCode()
    {
        $exception = DomainExceptionForTest::build(self::TEST_MESSAGE, self::TEST_CODE);

        self::assertEquals(self::TEST_MESSAGE, $exception->getMessage());
        self::assertEquals(self::TEST_CODE, $exception->getCode());
    }
}
