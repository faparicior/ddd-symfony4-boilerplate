<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

use Carbon\Carbon;

abstract class DateValue
{
    private Carbon $date;
    private string $timezone;

    /**
     * Date constructor.
     * @param string $date
     * @param string $timezone
     */
    final private function __construct(?string $date, string $timezone)
    {
        $this->date = Carbon::parse($date, $timezone);
        $this->timezone = $timezone;
    }

    /**
     * @param string $date
     * @param string $timezone
     * @return DateValue
     */
    final public static function build(string $date, string $timezone = 'UTC'): self
    {
        return new static($date, $timezone);
    }

    final public function value(): ?string
    {
        return $this->date->toISOString();
    }

    public function timezone(): string
    {
        return $this->timezone;
    }

    final public function equals(self $valueObject): bool
    {
        return $this->date->toISOString() === $valueObject->value();
    }

    final public function addHours(int $hours): ?self
    {
        $newDate = $this->date->copy()->addHours($hours);
        $newDateISO = $newDate->toISOString();

        if(is_null($newDateISO))
        {
            return null;
        }

        return new static($newDateISO, $this->timezone);
    }

    final public function diffInHours(self $dateToCompare): int
    {
        return $this->date->diffInHours(Carbon::parse($dateToCompare->value(), $dateToCompare->timezone()));
    }
}
