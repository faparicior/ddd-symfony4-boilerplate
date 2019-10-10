<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

class IntegerValue
{
    /** @var int */
    private $value;

    private function __construct(int $value)
    {
        $this->value = $value;
    }

    public static function build(int $value)
    {
        return new static($value);
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }
}
