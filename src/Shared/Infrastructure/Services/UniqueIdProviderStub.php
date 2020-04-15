<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Services;

use Ramsey\Uuid\UuidFactory;

final class UniqueIdProviderStub implements UniqueIdProviderInterface
{
    public const USER_UUID = '73f2791e-eaa7-4f81-a8cc-7cc601cda30e';

    private $uuidToReturn;

    public function __construct(?UuidFactory $uuidGenerator)
    {
        $this->uuidToReturn = self::USER_UUID;
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
