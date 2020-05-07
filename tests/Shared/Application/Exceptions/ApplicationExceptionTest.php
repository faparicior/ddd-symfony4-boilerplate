<?php declare(strict_types=1);

namespace App\Tests\Shared\Application\Exceptions;

use App\Shared\Application\Exceptions\ApplicationException;
use PHPUnit\Framework\TestCase;

class DummyApplicationException extends ApplicationException
{

}

class ApplicationExceptionTest extends TestCase
{
    public function testApplicationExceptionCannotBeInstantiated()
    {
        self::expectException(\Error::class);

        new DummyApplicationException();
    }

    public function testApplicationExceptionCanBeBuilt()
    {
        $applicationException = DummyApplicationException::build("message", 100);
        self::assertEquals("message", $applicationException->getMessage());
        self::assertEquals(100, $applicationException->getCode());
    }
}