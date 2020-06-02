<?php

declare(strict_types=1);

namespace App\Tests\Shared\Ui\Http\Api\Rest;

use App\Shared\Application\Exceptions\ApplicationException;
use App\Shared\Domain\Exceptions\DomainException;
use App\Shared\Ui\Http\Api\Rest\AppController;
use League\Tactician\Setup\QuickStart;
use Monolog\Handler\TestHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DummyAppControllerWithDomainException extends AppController
{
    const TEST_ERROR_MESSAGE = 'test domain error message';

    public function handleRequest($data): ?array
    {
        throw DummyDomainException::build(self::TEST_ERROR_MESSAGE);
    }
}

class DummyAppControllerWithApplicationException extends AppController
{
    const TEST_ERROR_MESSAGE = 'test application error message';

    public function handleRequest($data): ?array
    {
        throw DummyApplicationException::build(self::TEST_ERROR_MESSAGE);
    }
}

class DummyAppControllerWithUiException extends AppController
{
    const TEST_ERROR_MESSAGE = 'test UI error message';

    public function handleRequest($data): ?array
    {
        throw DummyUiException::build(self::TEST_ERROR_MESSAGE);
    }
}

class DummyDomainException extends DomainException
{
}

class DummyApplicationException extends ApplicationException
{
}

class DummyUiException extends ApplicationException
{
}

class AppControllerTest extends TestCase
{
    private const TEST_ERROR_MESSAGE = 'test error message';
    private TestHandler $logHandler;
    private DummyAppControllerWithDomainException $controllerWithDomainException;
    private DummyAppControllerWithApplicationException $controllerWithApplicationException;
    private DummyAppControllerWithUiException $controllerWithUiException;
    private TestHandler $domainLogHandler;

    public function setUp()
    {
        parent::setUp();

        $bus = QuickStart::create([]);

        $log = new Logger('genericLog');
        $layersLog = new Logger('layersLog');
        $this->logHandler = new TestHandler();
        $this->domainLogHandler = new TestHandler();
        $log->pushHandler($this->logHandler);
        $layersLog->pushHandler($this->domainLogHandler);

        $this->controllerWithDomainException = new DummyAppControllerWithDomainException($bus, $log, $layersLog);
        $this->controllerWithApplicationException = new DummyAppControllerWithApplicationException($bus, $log, $layersLog);
        $this->controllerWithUiException = new DummyAppControllerWithUiException($bus, $log, $layersLog);
    }

    public function testAppControllerWritesErrorLogInCaseOfDomainException()
    {
        $data = json_encode([
            'blah' => '',
        ]);

        $request = Request::create('/test', 'POST', [], [], [], [], $data);

        $response = $this->controllerWithDomainException->execute($request);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertTrue($this->domainLogHandler->hasInfoThatContains(DummyAppControllerWithDomainException::TEST_ERROR_MESSAGE));
    }

    public function testAppControllerWritesErrorLogInCaseOfApplicationException()
    {
        $data = json_encode([
            'blah' => '',
        ]);

        $request = Request::create('/test', 'POST', [], [], [], [], $data);

        $response = $this->controllerWithApplicationException->execute($request);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertTrue($this->domainLogHandler->hasInfoThatContains(DummyAppControllerWithApplicationException::TEST_ERROR_MESSAGE));
    }

    public function testAppControllerWritesErrorLogInCaseOfUiException()
    {
        $data = json_encode([
            'blah' => '',
        ]);

        $request = Request::create('/test', 'POST', [], [], [], [], $data);

        $response = $this->controllerWithUiException->execute($request);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertTrue($this->domainLogHandler->hasInfoThatContains(DummyAppControllerWithUiException::TEST_ERROR_MESSAGE));
    }

    public function testAppControllerReturnsBadRequestWithInvalidVoidData()
    {
        $data = '';

        $request = Request::create('/test', 'POST', [], [], [], [], $data);

        $response = $this->controllerWithDomainException->execute($request);

        self::assertEquals(400, $response->getStatusCode());
        self::assertEquals('"Empty data or bad json received"', $response->getContent());
    }

    public function testAppControllerCatchUnexpectedExceptionAndLogsIt()
    {
        $data = 'TEST_SHOULD_FAIL_WITH_500_EXCEPTION';

        $request = Request::create('/test', 'POST', [], [], [], [], $data);

        $response = $this->controllerWithDomainException->execute($request);

        self::assertEquals(500, $response->getStatusCode());
        if ('1' === $_SERVER['APP_DEBUG']) {
            self::assertEquals('"Server error:TEST_SHOULD_FAIL_WITH_500_EXCEPTION"', $response->getContent());
        } else {
            self::assertEquals('""', $response->getContent());
        }
        self::assertTrue($this->logHandler->hasErrorThatContains('TEST_SHOULD_FAIL_WITH_500_EXCEPTION'));
    }
}
