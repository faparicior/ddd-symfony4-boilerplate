<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class LoggerContext implements Context
{
    private KernelInterface $kernel;
    private string $environment;
    private ContainerAwareLoader $containerAwareLoader;
    private ORMExecutor $executor;
    private string $logFile;

    public function __construct(
        KernelInterface $kernel,
        string $environment,
        ContainerAwareLoader $containerAwareLoader,
        ORMExecutor $executor,
        ORMPurger $purger
    ) {
        $this->kernel = $kernel;
        $this->environment = $environment;
        $this->containerAwareLoader = $containerAwareLoader;

        $this->executor = $executor;
        $this->executor->setPurger($purger);
        $this->logFile = $this->kernel->getLogDir().'/'.$this->kernel->getEnvironment().'.log';
    }

    /**
     * Checks, that log file response contains specified string.
     *
     * @Then /^the logfile should contain:$/
     */
    public function assertLogFileContains(string $text)
    {
        $fileContent = file_get_contents($this->logFile);

        if (false === strpos($fileContent, $text)) {
            throw new \RuntimeException('Log string not found');
        }
    }

    /**
     * @BeforeScenario @clearLogs
     */
    public function clearLogs()
    {
//        var_dump('GO!');
//        ob_flush();
        if (file_exists($this->logFile)) {
            unlink($this->logFile);
        }
    }
}
