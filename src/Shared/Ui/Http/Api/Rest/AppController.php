<?php

declare(strict_types=1);

namespace App\Shared\Ui\Http\Api\Rest;

use App\Shared\Application\Exceptions\ApplicationException;
use App\Shared\Domain\Exceptions\DomainException;
use App\Shared\Ui\Http\Api\Rest\Exceptions\InvalidDataException;
use App\Shared\Ui\Http\Api\Rest\Exceptions\UiException;
use Exception;
use League\Tactician\CommandBus;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

abstract class AppController
{
    protected CommandBus $bus;
    private LoggerInterface $logger;

    public function __construct(CommandBus $bus, LoggerInterface $logger)
    {
        $this->bus = $bus;
        $this->logger = $logger;
    }

    public function execute(Request $request): JsonResponse
    {
        try {
            $response = $this->evalCall($request->getContent());
        } catch (DomainException | ApplicationException | UiException $exception) {
            $this->logger->error($exception->getMessage(), [$exception->getTraceAsString()]);

            return JsonResponse::create(
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage(), [$exception->getTraceAsString()]);

            $message = ('1' === $_SERVER['APP_DEBUG']) ? 'Server error:'.$exception->getMessage() : '';

            return JsonResponse::create(
                $message,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return JsonResponse::create(
            $response,
            Response::HTTP_OK
        );
    }

    /**
     * @throws InvalidDataException | Exception
     */
    private function evalCall(string $content): ?array
    {
        if ('TEST_SHOULD_FAIL_WITH_500_EXCEPTION' === $content) {
            throw new Exception('TEST_SHOULD_FAIL_WITH_500_EXCEPTION', 500);
        }

        $data = json_decode($content, true);

        if (is_null($data)) {
            throw InvalidDataException::build();
        }

        return $this->handleRequest($data);
    }

    /**
     * @param $data
     *
     * @throws ApplicationException | DomainException
     */
    abstract public function handleRequest($data): ?array;
}
