<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use App\Tests\Behat\DataFixtures\UserSignUpFixtures;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
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

    /** @var ContainerAwareLoader */
    private $containerAwareLoader;

    /** @var ORMExecutor  */
    private $executor;

    public function __construct(KernelInterface $kernel, string $environment, ContainerAwareLoader $containerAwareLoader, ORMExecutor $executor, ORMPurger $purger)
    {
        $this->kernel = $kernel;
        $this->environment = $environment;
        $this->containerAwareLoader = $containerAwareLoader;

        $this->executor = $executor;
        $this->executor->setPurger($purger);
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
     * Checks, that current page response status is equal to specified
     * Example: Then the response status code should be 200
     * Example: And the response status code should be 400
     *
     * @Then /^the response status code should be (?P<code>\d+)$/
     * @param int $statusCodeExpected
     */
    public function theResponseStatusCodeShouldBe(int $statusCodeExpected)
    {
        $statusCode = $this->response->getStatusCode();

        if ($statusCode !== $statusCodeExpected) {
            throw new \RuntimeException('No valid status code response '.$statusCode.' instead '.$statusCodeExpected);
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

    /**
     * Checks, that HTML response contains specified string
     * Example: Then the response should contain "Batman is the hero Gotham deserves."
     * Example: And the response should contain "Batman is the hero Gotham deserves."
     *
     * @Then /^the response should contain:$/
     */
    public function assertResponseContains(PyStringNode $text)
    {
        $content = $this->response->getContent();

        if($content !== (string) $this->fixStepArgument($text))
        {
            throw new \RuntimeException('Unexpected response '. $content . 'instead '. $text);
        }
    }

    /**
     * Returns fixed step argument (with \\" replaced back to ")
     *
     * @param string $argument
     *
     * @return string
     */
    protected function fixStepArgument($argument)
    {
        return str_replace('\\"', '"', $argument);
    }

    /**
     * @BeforeScenario @fixtures
     */
    public function loadFixtures()
    {
//        var_dump('GO!');
//        ob_flush();

        $this->containerAwareLoader->addFixture(new UserSignUpFixtures());
        $this->executor->execute($this->containerAwareLoader->getFixtures(), false);
    }
}
