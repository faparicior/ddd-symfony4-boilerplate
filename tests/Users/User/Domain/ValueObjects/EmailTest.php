<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Domain\ValueObjects;

use App\Users\User\Domain\ValueObjects\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testEmailCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new Email();
    }

    public function testEmailCanBeBuilt()
    {
        $email = Email::build('test@test.de');

        self::assertInstanceOf(Email::class, $email);
        self::assertEquals('test@test.de', $email->value());
    }
}
