<?php declare(strict_types=1);

namespace App\Shared\Domain\Specifications;

abstract class SpecificationChain implements SpecificationChainInterface
{
    protected $specifications;

    protected $specificationChainResult = [];

    /**
     * @param bool $isSatisfied
     * @param SpecificationInterface $specification
     * @return bool
     * @throws \ReflectionException
     */
    final protected function processSpecificationResult(bool $isSatisfied, SpecificationInterface $specification)
    {
        $message = '';

        if (!$isSatisfied){
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
    final protected function returnFalseIfNoSpecifications(): bool
    {
        return count($this->specifications) > 0;
    }

    /**
     * @param bool $result
     * @param bool $isSatisfied
     * @return bool
     */
    protected function updateResult(bool $result, bool $isSatisfied): bool
    {
        if (!$isSatisfied || !$result) {
            return false;
        }

        return true;
    }
}
