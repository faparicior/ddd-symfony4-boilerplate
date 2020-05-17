<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Ui\Http\Api\Rest;

use App\Users\User\Application\DeleteUser\DeleteUserCommand;
use App\Users\User\Application\DeleteUser\DeleteUserCommandHandler;
use App\Users\User\Domain\User;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use App\Users\User\Ui\Http\Api\Rest\DeleteUserController;
use League\Tactician\Setup\QuickStart;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteUserControllerTest extends TestCase
{
    private const USERNAME = 'JohnDoe';
    private const EMAIL = 'test.email@gmail.com';
    private const NON_EXISTENT_EMAIL = 'non-email@gmail.com';
    private const PASSWORD = ",&+3RjwAu88(tyC'";

    private DeleteUserController $controller;

    public function setUp()
    {
        parent::setUp();

        $userRepository = new InMemoryUserRepository();

        $userRepository->create(User::build(
            UserId::build(),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD)
        ));

        $deleteUserCommandHandler = new DeleteUserCommandHandler($userRepository);

        $bus = QuickStart::create([DeleteUserCommand::class => $deleteUserCommandHandler]);

        $log = new Logger('genericLog');
        $domainLog = new Logger('domainLog');

        $this->controller = new DeleteUserController($bus, $log, $domainLog);
    }

    public function testUserCanBeDeleted()
    {
        $data = json_encode([
            'email' => self::EMAIL,
        ]);

        $request = Request::create('/users', 'DELETE', [], [], [], [], $data);

        $response = $this->controller->execute($request);

        self::assertJsonStringEqualsJsonString('{}', $response->getContent());
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testDeleteUserReturnsBadRequestWithInexistentUser()
    {
        $data = json_encode([
            'email' => self::NON_EXISTENT_EMAIL,
        ]);

        $request = Request::create('/users', 'DELETE', [], [], [], [], $data);

        $response = $this->controller->execute($request);

        self::assertEquals('"User not found"', $response->getContent());
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
