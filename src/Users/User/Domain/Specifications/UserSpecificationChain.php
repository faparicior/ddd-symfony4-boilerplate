<?php declare(strict_types=1);

namespace App\Users\User\Domain\Specifications;

use App\Shared\Domain\Specifications\SpecificationChainInterface;
use App\Users\User\Domain\User;

final class UserSpecificationChain implements SpecificationChainInterface
{
    /** @var UserSpecificationChain[] */
    private $specifications;
    private $specificationChainResult = [];

    final private function __construct(UserSpecificationInterface ...$specifications)
    {
        $this->specifications = $specifications;
    }

    final public static function build(UserSpecificationInterface ...$specifications)
    {
        return new static(...$specifications);
    }

    /**
     * @param User $user
     * @return bool
     * @throws \ReflectionException
     */
    final public function evalSpecifications(User $user): bool
    {
        $result = $this->returnFalseIfNoSpecifications();

        /** @var UserSpecificationInterface $specification */
        foreach ($this->specifications as $specification)
        {
            $message = '';
            $isSatisfied = $specification->isSatisfiedBy($user);
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
