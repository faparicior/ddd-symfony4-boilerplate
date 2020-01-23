<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DomainExceptionForTest extends DomainException
{

}

class DomainExceptionTest extends TestCase
{
    const TEST_MESSAGE = 'TestMessage';
    const TEST_CODE = 2;

    /**
     * @group Shared
     * @group Domain
     */
    public function testExceptionCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new DomainExceptionForTest();
    }

    /**
     * @group Shared
     * @group Domain
     */
    public function testExceptionCanBeBuilt()
    {
        $exception = DomainExceptionForTest::build();

        self::assertInstanceOf(DomainExceptionForTest::class, $exception);
    }

    /**
     * @group Shared
     * @group Domain
     */
    public function testExceptionCanBeCreatedWithMessageAndStatusCode()
    {
        $exception = DomainExceptionForTest::build(self::TEST_MESSAGE, self::TEST_CODE);

        self::assertEquals($exception->getMessage(), self::TEST_MESSAGE);
        self::assertEquals($exception->getCode(), self::TEST_CODE);
    }
}