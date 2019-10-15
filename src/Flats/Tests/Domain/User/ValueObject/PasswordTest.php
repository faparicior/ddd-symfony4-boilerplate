<?php declare(strict_types=1);

namespace App\Flats\Tests\Domain\User\ValueObject;

use App\Flats\Domain\User\ValueObject\Password;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class PasswordTest extends TestCase
{
    /**
     * @group Flats
     * @group Domain
     */
    public function testPasswordCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new Password();
    }

    /**
     * @group Flats
     * @group Domain
     */    public function testPasswordCanBeBuilt()
    {
        $Password = Password::build('UserTest');

        self::assertInstanceOf(Password::class, $Password);
        self::assertEquals('UserTest', $Password->value());
    }

}
