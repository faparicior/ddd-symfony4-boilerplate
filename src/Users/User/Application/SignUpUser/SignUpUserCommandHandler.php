<?php

declare(strict_types=1);

namespace App\Users\User\Application\SignUpUser;

use App\Shared\Domain\Exceptions\DomainException;
use App\Shared\Infrastructure\Services\UniqueIdProviderInterface;
use App\Users\User\Application\Exceptions\UserInvalidException;
use App\Users\User\Application\Service\UserCreator;
use App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException;
use App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use Exception;
use ReflectionException;

final class SignUpUserCommandHandler
{
    private UniqueIdProviderInterface $uniqueUuidProviderService;
    private UserCreator $userBuilder;

    public function __construct(UniqueIdProviderInterface $uniqueUuidProviderService, UserCreator $userBuilder)
    {
        $this->uniqueUuidProviderService = $uniqueUuidProviderService;
        $this->userBuilder = $userBuilder;
    }

    /**
     * @return array
     *
     * @throws DomainException
     * @throws PasswordInvalidByPolicyRulesException
     * @throws UserInvalidException
     * @throws UserNameInvalidByPolicyRulesException
     * @throws ReflectionException
     * @throws Exception
     */
    public function handle(SignUpUserCommand $command)
    {
        $userId = $this->uniqueUuidProviderService->generate();

        $user = $this->userBuilder->create(
            UserId::fromString($userId),
            UserName::build($command->username()),
            Email::build($command->email()),
            Password::build($command->password())
        );

        return [
            'id' => $user->userId()->value(),
            'userName' => $user->username()->value(),
            'email' => $user->email()->value(),
            'password' => $user->password()->value(),
        ];
    }
}
