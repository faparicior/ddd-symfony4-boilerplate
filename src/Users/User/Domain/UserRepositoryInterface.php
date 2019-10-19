<?php declare(strict_types=1);

namespace App\Users\User\Domain;


use App\Users\User\Domain\ValueObject\UserId;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;

interface UserRepositoryInterface
{
    public function create(User $user): void;

    public function findById(UserId $userId): ?User;
}
