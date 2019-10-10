<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UniqueIdentifier
{
    const UUID4_PATTERN = "/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/";

    /** @var UuidInterface */
    private $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return UniqueIdentifier
     * @throws \Exception
     */
    public static function build(): self
    {
        return new static(Uuid::uuid4());
    }

    /**
     * @param $uuid
     * @return UniqueIdentifier
     * @throws InvalidArgumentException
     */
    public static function fromString($uuid): self
    {
        if (!preg_match(self::UUID4_PATTERN, $uuid)) {
            throw new InvalidArgumentException();
        }

        return new self(Uuid::fromString($uuid));
    }

    public function value(): string
    {
        return $this->uuid->toString();
    }
}
