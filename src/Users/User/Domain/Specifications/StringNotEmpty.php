<?php declare(strict_types=1);

namespace App\Users\User\Domain\Specifications;

use App\Shared\Domain\Specifications\StringSpecificationInterface;

class StringNotEmpty implements StringSpecificationInterface
{
    private function __construct()
    {

    }

    public static function build()
    {
        return new static();
    }

    public function isSatisfiedBy(string $data): bool
    {
        return strlen($data) > 0;
    }
}
