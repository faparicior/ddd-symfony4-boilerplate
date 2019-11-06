<?php declare(strict_types=1);

namespace App\Shared\Domain\Specifications;

class SpecificationChain
{
    /** @var SpecificationInterface[] */
    private $specifications;

    final private function __construct(SpecificationInterface ...$specifications)
    {
        $this->specifications = $specifications;
    }

    final public function build(SpecificationInterface ...$specifications)
    {
        return new static($specifications);
    }
}
