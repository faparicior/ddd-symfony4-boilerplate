<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Carbon\Carbon;

class DateValue
{
    /** @var string */
    private $date;

    /**
     * Date constructor.
     * @param string $date
     * @throws \Exception
     */
    private function __construct(string $date)
    {
        $this->date = Carbon::parse($date);
    }

    /**
     * @param string $date
     * @return DateValue
     * @throws \Exception
     */
    public static function build(string $date): self
    {
        return new static($date);
    }

    public function value(): string
    {
        return $this->date->toISOString();
    }
}
