<?php

declare(strict_types=1);

namespace App\Tests\Shared\Ui\Http\Api\Rest\Exceptions;

use App\Shared\Ui\Http\Api\Rest\Exceptions\InvalidDataException;
use PHPUnit\Framework\TestCase;

class InvalidDataExceptionTest extends TestCase
{
    const TEST_MESSAGE = 'TestMessage';
    const TEST_CODE = 2;
    const INVALID_DATA_DEFAULT_MESSAGE = 'Empty data or bad json received';

    public function testInvalidDataExceptionCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new InvalidDataException();
    }

    public function testInvalidDataExceptionCanBeCreatedWithDefaultMessage()
    {
        $exception = InvalidDataException::build();

        self::assertEquals(self::INVALID_DATA_DEFAULT_MESSAGE, $exception->getMessage());
    }

    public function testInvalidDataExceptionCanBeCreatedWithMessageAndStatusCode()
    {
        $exception = InvalidDataException::build(self::TEST_MESSAGE, self::TEST_CODE);

        self::assertEquals(self::TEST_MESSAGE, $exception->getMessage());
        self::assertEquals(self::TEST_CODE, $exception->getCode());
    }
}
