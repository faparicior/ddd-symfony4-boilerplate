<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Services;

use Exception;
use Ramsey\Uuid\UuidFactory;

final class UniqueIdProvider implements UniqueIdProviderInterface
{
    private UuidFactory $uuidGenerator;

    public function __construct(UuidFactory $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function generate(): string
    {
        return $this->uuidGenerator->uuid4()->toString();
    }
}
