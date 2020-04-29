<?php declare(strict_types=1);

namespace App\Users\User\Ui\Http\Api\Rest;

use App\Shared\Domain\Exceptions\DomainException;
use App\Users\User\Application\SignUpUser\SignUpUserCommand;
use League\Tactician\CommandBus;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SignUpUserController
{
    private CommandBus $bus;
    private LoggerInterface $logger;

    public function __construct(CommandBus $bus, LoggerInterface $logger)
    {
        $this->bus = $bus;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function execute(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

//            if (is_null($data)) {
//                return JsonResponse::create(
//                    'Empty data',
//                    Response::HTTP_BAD_REQUEST
//                );
//            }

            $signUpUser = SignUpUserCommand::build(
                $data['userName'],
                $data['email'],
                $data['password']
            );

            $response = $this->bus->handle($signUpUser);
        } catch (DomainException $exception) {
            $this->logger->error($exception->getMessage(), [$exception->getTraceAsString()]);

            return JsonResponse::create(
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (Throwable $exception)
        {
            $this->logger->error($exception->getMessage(), [$exception->getTraceAsString()]);

            return JsonResponse::create(
//                'Server error:'.$exception->getMessage(),
                '',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return JsonResponse::create(
            $response,
            Response::HTTP_OK
        );
    }
}
