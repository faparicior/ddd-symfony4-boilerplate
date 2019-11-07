<?php declare(strict_types=1);

namespace App\Shared\Domain\Specifications;

class StringSpecificationChain
{
    /** @var StringSpecificationInterface[] */
    private $specifications;

    final private function __construct(StringSpecificationInterface ...$specifications)
    {
        $this->specifications = $specifications;
    }

    final public static function build(StringSpecificationInterface ...$specifications)
    {
        return new static(...$specifications);
    }

    final public function evalSpecifications(string $data)
    {
        $result = false;

        foreach ($this->specifications as $specification)
        {
            $result = $specification->isSatisfiedBy($data);

            if (!$result)
            {
                break;
            }
        }

        return $result;
    }
}
