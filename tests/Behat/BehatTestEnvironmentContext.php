<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Symfony\Component\HttpFoundation\Response;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class BehatTestEnvironmentContext implements Context
{
    private string $environment;
    private ApiContext $apiContext;

    public function __construct(string $environment)
    {
        $this->environment = $environment;
    }

    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->apiContext = $environment->getContext(ApiContext::class);
    }

    /**
     * @Then the application's kernel should use :expected environment
     */
    public function kernelEnvironmentShouldBe(string $expected): void
    {
        if ($this->environment !== $expected) {
            throw new \RuntimeException();
        }
    }
}
