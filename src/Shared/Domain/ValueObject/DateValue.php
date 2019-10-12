<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Carbon\Carbon;

abstract class DateValue
{
    /** @var string */
    private $date;

    /**
     * Date constructor.
     * @param string $date
     * @param string $timezone
     */
    final private function __construct(string $date, string $timezone = 'UTC')
    {
        // TODO: Test timezone
        $this->date = Carbon::parse($date, $timezone);
    }

    /**
     * @param string $date
     * @return DateValue
     * @throws \Exception
     */
    final public static function build(string $date): self
    {
        return new static($date);
    }

    final public function value(): string
    {
        return $this->date->toISOString();
    }

    final public function equals(self $valueObject): bool
    {
        return $this->date->toISOString() === $valueObject->value();
    }
}
