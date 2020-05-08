<?php

declare(strict_types=1);

namespace App\Users\User\Infrastructure\Persistence;

use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

final class DoctrineUserRepository extends EntityRepository implements UserRepositoryInterface
{
    private const CLASS_NAME = User::class;

    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct($manager, $manager->getClassMetadata(self::CLASS_NAME));
    }

    /**
     * @throws ORMException
     */
    public function create(User $user): void
    {
        $this->_em->persist($user);
    }

    public function findById(UserId $userId): ?User
    {
        return $this->_em->getRepository(self::CLASS_NAME)->findOneBy([
            'userId' => $userId,
        ]);
    }

    public function findByName(UserName $userName): ?User
    {
        return $this->_em->getRepository(self::CLASS_NAME)->findOneBy([
            'username' => $userName,
        ]);
    }

    public function findByEmail(Email $email): ?User
    {
        return $this->_em->getRepository(self::CLASS_NAME)->findOneBy([
            'email' => $email,
        ]);
    }

    public function delete(User $user): void
    {
        $this->_em->remove($user);
    }
}
