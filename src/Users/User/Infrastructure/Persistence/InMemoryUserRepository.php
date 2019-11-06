<?php declare(strict_types=1);

namespace App\Users\User\Infrastructure\Persistence;

use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\UserId;

final class InMemoryUserRepository implements UserRepositoryInterface
{
    private $usersTable;

    public function __construct()
    {
        $this->usersTable = [];
    }

    public function create(User $user): void
    {
        $this->usersTable[$user->userId()->value()] = $user;
    }

    public function findById(UserId $userId): ?User
    {
        return $this->usersTable[$userId->value()] ?? null;
    }
}
