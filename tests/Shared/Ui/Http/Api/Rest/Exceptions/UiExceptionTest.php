<?php

declare(strict_types=1);

namespace App\Tests\Shared\Ui\Http\Api\Rest\Exceptions;

use App\Shared\Ui\Http\Api\Rest\Exceptions\UiException;
use PHPUnit\Framework\TestCase;

class UiExceptionForTest extends UiException
{
}

class UiExceptionTest extends TestCase
{
    private const TEST_MESSAGE = 'TestMessage';
    private const TEST_CODE = 2;

    public function testExceptionCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new UiExceptionForTest();
    }

    public function testExceptionCanBeBuilt()
    {
        $exception = UiExceptionForTest::build();

        self::assertInstanceOf(UiExceptionForTest::class, $exception);
    }

    public function testExceptionCanBeCreatedWithMessageAndStatusCode()
    {
        $exception = UiExceptionForTest::build(self::TEST_MESSAGE, self::TEST_CODE);

        self::assertEquals(self::TEST_MESSAGE, $exception->getMessage());
        self::assertEquals(self::TEST_CODE, $exception->getCode());
    }
}
