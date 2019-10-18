<?php declare(strict_types=1);

namespace App\Flats\User\Application\SignUpUser;

use App\Shared\Domain\Service\UniqueIdProviderServiceInterface;

final class SignUpUserCommandHandler
{
    /** @var UniqueIdProviderServiceInterface */
    private $uniqueUuidProviderService;

    public function __construct(UniqueIdProviderServiceInterface $uniqueUuidProviderService)
    {

        $this->uniqueUuidProviderService = $uniqueUuidProviderService;
    }

    /**
     * @param SignUpUserCommand $command
     * @return array
     * @throws \Exception
     */
    public function handle(SignUpUserCommand $command)
    {

        return [
            "id" => $this->uniqueUuidProviderService->generate(),
            "userName" => "JohnDoe",
            "email" => "test.email@gmail.com",
            "password" => ",&+3RjwAu88(tyC'"
        ];
    }
}
