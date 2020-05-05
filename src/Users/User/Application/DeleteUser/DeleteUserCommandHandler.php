<?php declare(strict_types=1);

namespace App\Users\User\Application\DeleteUser;

use App\Shared\Domain\Exceptions\DomainException;
use App\Users\User\Application\Exceptions\UserNotFoundException;
use App\Users\User\Application\Service\UserBuilder;
use App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException;
use App\Users\User\Domain\Exceptions\UserInvalidException;
use App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use App\Shared\Infrastructure\Services\UniqueIdProviderInterface;
use Exception;
use ReflectionException;

final class DeleteUserCommandHandler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param DeleteUserCommand $command
     * @return bool
     * @throws DomainException
     * @throws Exception|UserNotFoundException
     */
    public function handle(DeleteUserCommand $command)
    {
        $user = $this->userRepository->findByEmail(Email::build($command->email()));

        if (is_null($user)) {
            throw UserNotFoundException::build();
        }

        $this->userRepository->delete($user);

        return true;
    }
}
