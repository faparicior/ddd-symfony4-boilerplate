<?php declare(strict_types=1);

namespace App\Tests\Users\User\Ui\Http\Api\Rest;

use App\Shared\Infrastructure\Service\UniqueIdProviderStub;
use App\Users\User\Application\SignUpUser\SignUpUserCommand;
use App\Users\User\Application\SignUpUser\SignUpUserCommandHandler;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use App\Users\User\Ui\Http\Api\Rest\SignUpUserController;
use League\Tactician\CommandBus;
use League\Tactician\Setup\QuickStart;
use Ramsey\Uuid\UuidFactory;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SignUpUserControllerTest extends TestCase
{
    private const USER_UUID = '73f2791e-eaa7-4f81-a8cc-7cc601cda30e';
    private const USERNAME = 'JohnDoe';
    private const EMAIL = 'test.email@gmail.com';
    private const PASSWORD = ",&+3RjwAu88(tyC'";

    /** @var CommandBus */
    private $bus;

    public function setUp()
    {
        parent::setUp();

        $uniqueUuidProviderService = new UniqueIdProviderStub(new UuidFactory());
        $uniqueUuidProviderService->setUuidToReturn(self::USER_UUID);

        $userRepository = new InMemoryUserRepository();

        $signUpUserCommandHandler = new SignUpUserCommandHandler(
            $uniqueUuidProviderService, $userRepository
        );

        $this->bus = QuickStart::create([SignUpUserCommand::class => $signUpUserCommandHandler]);
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Ui
     */
    public function testUserCanSignUp()
    {
        $data = json_encode([
            "userName" => self::USERNAME,
            "email" => self::EMAIL,
            "password" => self::PASSWORD
        ]);

        $request = Request::create('/users', 'POST', [], [], [], [], $data);

        $controller = new SignUpUserController($this->bus);

        $response = $controller->execute($request);

        $expectedResponse = json_encode([
            "id" => self::USER_UUID,
            "userName" => self::USERNAME,
            "email" => self::EMAIL,
            "password" => self::PASSWORD
        ]);

        self::assertJsonStringEqualsJsonString($expectedResponse, $response->getContent());
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}
