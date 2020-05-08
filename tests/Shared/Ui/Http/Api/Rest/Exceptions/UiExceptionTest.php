<?php declare(strict_types=1);

namespace App\Tests\Shared\Ui\Http\Api\Rest\Exceptions;

use App\Shared\Ui\Http\Api\Rest\Exceptions\UiException;
use PHPUnit\Framework\TestCase;

class UiExceptionForTest extends UiException
{

}

class UiExceptionTest extends TestCase
{
    const TEST_MESSAGE = 'TestMessage';
    const TEST_CODE = 2;

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testExceptionCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new UiExceptionForTest();
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testExceptionCanBeBuilt()
    {
        $exception = UiExceptionForTest::build();

        self::assertInstanceOf(UiExceptionForTest::class, $exception);
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     */
    public function testExceptionCanBeCreatedWithMessageAndStatusCode()
    {
        $exception = UiExceptionForTest::build(self::TEST_MESSAGE, self::TEST_CODE);

        self::assertEquals($exception->getMessage(), self::TEST_MESSAGE);
        self::assertEquals($exception->getCode(), self::TEST_CODE);
    }
}
