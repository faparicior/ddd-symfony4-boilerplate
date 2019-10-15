<?php declare(strict_types=1);

namespace App\Flats\Tests\Domain\User\ValueObject;

use App\Flats\Domain\User\ValueObject\Email;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class EmailTest extends TestCase
{
    /**
     * @group Flats
     * @group Domain
     */
    public function testEmailCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new Email();
    }

    /**
     * @group Flats
     * @group Domain
     */
    public function testEmailCanBeBuilt()
    {
        $email = Email::build('test@test.de');

        self::assertInstanceOf(Email::class, $email);
        self::assertEquals('test@test.de', $email->value());
    }

}
