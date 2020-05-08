<?php

declare(strict_types=1);

namespace App\Users\User\Domain;

use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;

interface UserRepositoryInterface
{
    public function create(User $user): void;

    public function findById(UserId $userId): ?User;

    public function findByName(UserName $userName): ?User;

    public function findByEmail(Email $email): ?User;

    public function delete(User $user): void;
}
