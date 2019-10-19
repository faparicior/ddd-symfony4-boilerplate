<?php declare(strict_types=1);

namespace App\Shared\Domain\Service;

use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidInterface;

final class UniqueIdProviderStub implements UniqueIdProviderInterface
{
    private $uuidToReturn;

    public function __construct(?UuidFactory $uuidGenerator)
    {
        $this->uuidToReturn = '';
    }

    public function setUuidToReturn(string $uuid): void
    {
        $this->uuidToReturn = $uuid;
    }

    public function generate(): string
    {
        return $this->uuidToReturn;
    }
}
