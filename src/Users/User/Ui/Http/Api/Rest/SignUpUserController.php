<?php declare(strict_types=1);

namespace App\Users\User\Ui\Http\Api\Rest;

use App\Users\User\Application\SignUpUser\SignUpUserCommand;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SignUpUserController
{
    /** @var CommandBus */
    private $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function execute(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $signUpUser = SignUpUserCommand::build(
            $data['userName'],
            $data['email'],
            $data['password']
        );

        $response = $this->bus->handle($signUpUser);
        
        return JsonResponse::create(
            $response,
            Response::HTTP_OK
        );
    }
}
