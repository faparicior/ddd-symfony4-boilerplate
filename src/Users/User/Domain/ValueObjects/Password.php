<?php declare(strict_types=1);

namespace App\Users\User\Domain\ValueObjects;

use App\Shared\Domain\Specifications\SpecificationChain;
use App\Shared\Domain\ValueObjects\StringValue;

class Password extends StringValue
{
    public static function build(string $value, ?SpecificationChain $specificationChain = null)
    {
        return new static($value, $specificationChain);
    }
}
