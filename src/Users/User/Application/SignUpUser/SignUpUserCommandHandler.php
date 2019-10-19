<?php declare(strict_types=1);

namespace App\Users\User\Application\SignUpUser;

use App\Users\User\Application\Service\UserBuilder;
use App\Users\User\Domain\ValueObject\Email;
use App\Users\User\Domain\ValueObject\Password;
use App\Users\User\Domain\ValueObject\UserId;
use App\Users\User\Domain\ValueObject\UserName;
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
        $userId = $this->uniqueUuidProviderService->generate();

        $user = UserBuilder::build(
            UserId::fromString($userId),
            UserName::build($command->username()),
            Email::build($command->email()),
            Password::build($command->password())
        );

        return [
            "id" => $user->userId()->value(),
            "userName" => $user->username()->value(),
            "email" => $user->email()->value(),
            "password" => $user->password()->value()
        ];
    }
}
