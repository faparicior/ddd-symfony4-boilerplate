<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class BehatTestEnvironmentContext extends MinkContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Response|null */
    private $response;

    /** @var string */
    private $environment;

    public function __construct(KernelInterface $kernel, string $environment)
    {
        $this->kernel = $kernel;
        $this->environment = $environment;
    }

    /**
     * @When a demo scenario sends a request to :path
     * @throws \Exception
     */
    public function sendsARequestTo(string $path): void
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived(): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }
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

    /**
     * @When /^(?:I )?send a "([A-Z]+)" request to "([^"]+)" with body:$/
     * @param string $method
     * @param string $path
     * @param string $data
     * @throws \Exception
     */
    public function iSendARequestToWithBody(string $method, string $path, string $data)
    {
        $this->response = $this->kernel->handle(Request::create($path, $method, [], [], [], [], $data));
    }
}
