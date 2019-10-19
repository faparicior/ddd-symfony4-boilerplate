<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class UniqueIdentifier
{
    const UUID4_PATTERN = "/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/";

    /** @var UuidInterface */
    private $uuid;

    final private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @throws \Exception
     */
    final public static function build(): self
    {
        return new static(Uuid::uuid4());
    }

    /**
     * @throws \App\Shared\Domain\Exception\DomainException
     */
    final public static function fromString($uuid)
    {
        if (!preg_match(self::UUID4_PATTERN, $uuid)) {
            throw InvalidArgumentException::build();
        }

        return new static(Uuid::fromString($uuid));
    }

    final public function value(): string
    {
        return $this->uuid->toString();
    }

    final public function equals(self $valueObject): bool
    {
        return $this->uuid->toString() === $valueObject->value();
    }
}
