<?php

declare(strict_types=1);

namespace App\Tests\Shared\Ui\Http\Api\Rest;

use App\Shared\Domain\Exceptions\DomainException;
use App\Shared\Ui\Http\Api\Rest\AppController;
use League\Tactician\CommandBus;
use League\Tactician\Setup\QuickStart;
use Monolog\Handler\TestHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DummyAppController extends AppController
{
    public function handleRequest($data): ?array
    {
        throw DummyException::build('test error message');
    }
}

class DummyException extends DomainException
{
}

class AppControllerTest extends TestCase
{
    const TEST_ERROR_MESSAGE = 'test error message';
    private CommandBus $bus;
    private Logger $log;
    private TestHandler $logHandler;

    public function setUp()
    {
        parent::setUp();

        $this->bus = QuickStart::create([]);

        $this->log = new Logger('testLog');
        $this->logHandler = new TestHandler();
        $this->log->pushHandler($this->logHandler);
    }

    public function testAppControllerWritesErrorLogInCaseOfException()
    {
        $data = json_encode([
            'blah' => '',
        ]);

        $request = Request::create('/test', 'POST', [], [], [], [], $data);

        $controller = new DummyAppController($this->bus, $this->log);

        $response = $controller->execute($request);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertTrue($this->logHandler->hasErrorThatContains(self::TEST_ERROR_MESSAGE));
    }

    public function testAppControllerReturnsBadRequestWithInvalidVoidData()
    {
        $data = '';

        $request = Request::create('/test', 'POST', [], [], [], [], $data);

        $controller = new DummyAppController($this->bus, $this->log);

        $response = $controller->execute($request);

        self::assertEquals(400, $response->getStatusCode());
        self::assertEquals('"Empty data or bad json received"', $response->getContent());
    }

    public function testAppControllerCatchUnexpectedException()
    {
        $data = 'TEST_SHOULD_FAIL_WITH_500_EXCEPTION';

        $request = Request::create('/test', 'POST', [], [], [], [], $data);

        $controller = new DummyAppController($this->bus, $this->log);

        $response = $controller->execute($request);

        self::assertEquals(500, $response->getStatusCode());
        if ('1' === $_SERVER['APP_DEBUG']) {
            self::assertEquals('"Server error:TEST_SHOULD_FAIL_WITH_500_EXCEPTION"', $response->getContent());
        } else {
            self::assertEquals('""', $response->getContent());
        }
    }
}
