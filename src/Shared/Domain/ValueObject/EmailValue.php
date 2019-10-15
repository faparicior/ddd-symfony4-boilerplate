<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\InvalidEmailException;

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
     * @throws \App\Shared\Domain\Exception\DomainException
     */
    final public static function build(string $email): EmailValue
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
}
