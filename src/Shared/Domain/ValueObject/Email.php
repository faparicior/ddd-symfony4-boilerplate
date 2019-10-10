<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\InvalidEmailException;

class Email
{
    /** @var string */
    private $email;

    private function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @param string $email
     * @return Email
     * @throws InvalidEmailException
     */
    public static function build(string $email): Email
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw InvalidEmailException::build();
        }

        return new static($email);
    }

    public function value(): string
    {
        return $this->email;
    }
}
