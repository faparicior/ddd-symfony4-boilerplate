<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
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
final class ApiContext implements Context
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
    public function sendsARequestTo(string $path): Response
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));

        return $this->response;
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
     * @Then the response content should be in JSON
     */
    public function theResponseContentShouldBeInJson(): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }

        $object = json_decode($this->response->getContent());

        if($object === null) {
            throw new \RuntimeException('No valid JSON in content response');
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

    /**
     * @Given /^should be equal to:$/
     */
    public function shouldBeEqualTo(PyStringNode $dataExpected)
    {
        $object = json_decode($this->response->getContent());
        $objectExpected = json_decode($dataExpected->getRaw());

        if($objectExpected != $object)
        {
            throw new \RuntimeException('Unexpected Json in response');
        }
    }
}
