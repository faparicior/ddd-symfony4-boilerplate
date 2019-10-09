<?php declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SymfonyOkTest extends WebTestCase
{
    public function testThatSymfonyIsOnline()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
