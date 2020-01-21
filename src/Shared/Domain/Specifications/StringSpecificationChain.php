<?php declare(strict_types=1);

namespace App\Shared\Domain\Specifications;

class StringSpecificationChain
{
    /** @var StringSpecificationInterface[] */
    private $specifications;
    private $specificationChainResult = [];

    final private function __construct(StringSpecificationInterface ...$specifications)
    {
        $this->specifications = $specifications;
    }

    final public static function build(StringSpecificationInterface ...$specifications)
    {
        return new static(...$specifications);
    }

    /**
     * @param string $data
     * @return bool
     * @throws \ReflectionException
     */
    final public function evalSpecifications(string $data): bool
    {
        $result = $this->returnFalseIfNoSpecifications();

        /** @var StringSpecificationInterface $specification */
        foreach ($this->specifications as $specification)
        {
            $message = '';
            $isSatisfied = $specification->isSatisfiedBy($data);
            if (!$isSatisfied) {
                $message = $specification->getFailedMessage();
            }

            $this->specificationChainResult = array_merge(
                $this->specificationChainResult,
                [(new \ReflectionClass($specification))->getShortName() =>
                    [
                        'value' => $isSatisfied,
                        'message' => $message
                    ]
                ]
            );

            if (!$isSatisfied) {
                $result = false;
            }
        }

        return $result;
    }

    final public function getResults(): array
    {
        return $this->specificationChainResult;
    }

    final public function getFailedResults(): array
    {
        $failedResults = [];

        foreach ($this->specificationChainResult as $key => $specificationResult)
        {
            if(!$specificationResult['value']) {
                $failedResults = array_merge($failedResults , [$key => $specificationResult['message']]);
            }
        }

        return $failedResults;
    }

    /**
     * @return bool
     */
    final private function returnFalseIfNoSpecifications(): bool
    {
        return count($this->specifications) > 0;
    }
}
