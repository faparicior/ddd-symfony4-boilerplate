<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\DomainException;
use App\Shared\Domain\Exceptions\InvalidEmailException;

abstract class EmailValue
{
    /** @var string */
    private $email;

    final private function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @param string $email
     * @return EmailValue
     * @throws DomainException
     */
    final public static function build(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw InvalidEmailException::build();
        }

        return new static($email);
    }

    final public function value(): string
    {
        return $this->email;
    }

    final public function equals(self $valueObject): bool
    {
        return $this->email === $valueObject->value();
    }

    final public function __toString(): string
    {
        return $this->value();
    }
}
