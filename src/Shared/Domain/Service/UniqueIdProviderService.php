<?php declare(strict_types=1);

namespace App\Shared\Domain\Service;

use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidInterface;

final class UniqueIdProviderService implements UniqueIdProviderServiceInterface
{
    /** @var UuidInterface */
    private $uuidGenerator;

    public function __construct(UuidFactory $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function generate(): string
    {
        return $this->uuidGenerator->uuid4()->toString();
    }
}
