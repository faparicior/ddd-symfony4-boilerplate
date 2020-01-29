<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Services;

use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidInterface;

final class UniqueIdProvider implements UniqueIdProviderInterface
{
    /** @var UuidFactory */
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
