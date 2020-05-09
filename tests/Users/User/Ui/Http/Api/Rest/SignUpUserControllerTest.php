<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Ui\Http\Api\Rest;

use App\Shared\Infrastructure\Services\UniqueIdProviderStub;
use App\Users\User\Application\SignUpUser\SignUpUserCommand;
use App\Users\User\Application\SignUpUser\SignUpUserCommandHandler;
use App\Users\User\Domain\Specifications\UserEmailIsUnique;
use App\Users\User\Domain\Specifications\UserNameIsUnique;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use App\Users\User\Ui\Http\Api\Rest\SignUpUserController;
use League\Tactician\CommandBus;
use League\Tactician\Setup\QuickStart;
use Monolog\Handler\TestHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SignUpUserControllerTest extends TestCase
{
    private const USER_UUID = '73f2791e-eaa7-4f81-a8cc-7cc601cda30e';
    private const USERNAME = 'JohnDoe';
    private const EMAIL = 'test.email@gmail.com';
    private const BAD_EMAIL = 'test.emailgmail.com';
    private const PASSWORD = ",&+3RjwAu88(tyC'";
    private const INVALID_PASSWORD = ",&+3RjR'";

    /** @var CommandBus */
    private $bus;

    /** @var Logger */
    private $log;

    /** @var TestHandler */
    private $logHandler;

    public function setUp()
    {
        parent::setUp();

        $uniqueUuidProviderService = new UniqueIdProviderStub(new UuidFactory());
        $uniqueUuidProviderService->setUuidToReturn(self::USER_UUID);

        $userRepository = new InMemoryUserRepository();

        $signUpUserCommandHandler = new SignUpUserCommandHandler(
            $uniqueUuidProviderService,
            $userRepository,
            UserSpecificationChain::build(...[
                UserEmailIsUnique::build($userRepository),
                UserNameIsUnique::build($userRepository),
            ])
        );

        $this->bus = QuickStart::create([SignUpUserCommand::class => $signUpUserCommandHandler]);

        $this->log = new Logger('testLog');
        $this->logHandler = new TestHandler();
        $this->log->pushHandler($this->logHandler);
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Ui
     */
    public function testUserCanSignUp()
    {
        $data = json_encode([
            'userName' => self::USERNAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $request = Request::create('/users', 'POST', [], [], [], [], $data);

        $controller = new SignUpUserController($this->bus, $this->log);

        $response = $controller->execute($request);

        $expectedResponse = json_encode([
            'id' => self::USER_UUID,
            'userName' => self::USERNAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        self::assertJsonStringEqualsJsonString($expectedResponse, $response->getContent());
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Ui
     */
    public function testUserWithIncorrectEmailCannotSignUp()
    {
        $data = json_encode([
            'userName' => self::USERNAME,
            'email' => self::BAD_EMAIL,
            'password' => self::PASSWORD,
        ]);

        $request = Request::create('/users', 'POST', [], [], [], [], $data);

        $controller = new SignUpUserController($this->bus, $this->log);

        $response = $controller->execute($request);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Ui
     */
    public function testUserWithEmptyPasswordCannotSignUp()
    {
        $data = json_encode([
            'userName' => self::USERNAME,
            'email' => self::EMAIL,
            'password' => '',
        ]);

        $request = Request::create('/users', 'POST', [], [], [], [], $data);

        $controller = new SignUpUserController($this->bus, $this->log);

        $response = $controller->execute($request);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Ui
     */
    public function testUserWithEmptyUsernameCannotSignUp()
    {
        $data = json_encode([
            'userName' => '',
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $request = Request::create('/users', 'POST', [], [], [], [], $data);

        $controller = new SignUpUserController($this->bus, $this->log);

        $response = $controller->execute($request);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
