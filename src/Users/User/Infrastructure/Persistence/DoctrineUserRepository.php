<?php declare(strict_types=1);

namespace App\Users\User\Infrastructure\Persistence;

use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\UserId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class DoctrineUserRepository extends EntityRepository implements UserRepositoryInterface
{

    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct($manager, $manager->getClassMetadata(User::class));
    }

    /**
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(User $user): void
    {
        $this->_em->persist($user);
    }

    public function findById(UserId $userId): ?User
    {
        return null;
    }
}
