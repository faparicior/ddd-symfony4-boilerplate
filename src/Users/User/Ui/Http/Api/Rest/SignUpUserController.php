<?php declare(strict_types=1);

namespace App\Users\User\Ui\Http\Api\Rest;

use App\Shared\Domain\Exceptions\DomainException;
use App\Users\User\Application\SignUpUser\SignUpUserCommand;
use League\Tactician\CommandBus;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SignUpUserController
{
    /** @var CommandBus */
    private $bus;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(CommandBus $bus, LoggerInterface $logger)
    {
        $this->bus = $bus;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @throws DomainException
     */
    public function execute(Request $request): JsonResponse
    {
        try {

            $data = json_decode($request->getContent(), true);

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
        } catch (\Exception $exception)
        {
            $this->logger->error($exception->getMessage(), [$exception->getTraceAsString()]);

            return JsonResponse::create(
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
