<?php declare(strict_types=1);

namespace App\Tests\Users\User\Domain\ValueObjects;

use App\Users\User\Domain\ValueObjects\Email;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class EmailTest extends TestCase
{
    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testEmailCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new Email();
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testEmailCanBeBuilt()
    {
        $email = Email::build('test@test.de');

        self::assertInstanceOf(Email::class, $email);
        self::assertEquals('test@test.de', $email->value());
    }

}
