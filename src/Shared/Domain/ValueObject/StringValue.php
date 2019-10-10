<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

class StringValue
{
    /** @var string */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function build(string $value)
    {
        return new static($value);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
