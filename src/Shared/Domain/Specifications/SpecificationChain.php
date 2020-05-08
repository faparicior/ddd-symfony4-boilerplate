<?php

declare(strict_types=1);

namespace App\Shared\Domain\Specifications;

use ReflectionClass;
use ReflectionException;

abstract class SpecificationChain implements SpecificationChainInterface
{
    protected array $specifications;
    protected array $specificationChainResult = [];

    /**
     * @throws ReflectionException
     */
    final protected function processSpecificationResult(bool $isSatisfied, SpecificationInterface $specification)
    {
        $message = '';

        if (!$isSatisfied) {
            $message = $specification->getFailedMessage();
        }

        $this->specificationChainResult = array_merge(
            $this->specificationChainResult,
            [(new ReflectionClass($specification))->getShortName() => [
                    'value' => $isSatisfied,
                    'message' => $message,
                ],
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

        foreach ($this->specificationChainResult as $key => $specificationResult) {
            if (!$specificationResult['value']) {
                $failedResults = array_merge($failedResults, [$key => $specificationResult['message']]);
            }
        }

        return $failedResults;
    }

    final protected function returnFalseIfNoSpecifications(): bool
    {
        return count($this->specifications) > 0;
    }

    protected function updateResult(bool $result, bool $isSatisfied): bool
    {
        if (!$isSatisfied || !$result) {
            return false;
        }

        return true;
    }
}
