<?php declare(strict_types=1);

namespace App\Flats\Tests\Domain\User\ValueObject;

use App\Flats\Domain\User\ValueObject\UserName;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserNameTest extends TestCase
{
    /**
     * @group Flats
     * @group Domain
     */
    public function testUserNameCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new UserName();
    }

    /**
     * @group Flats
     * @group Domain
     */    public function testUserNameCanBeBuilt()
    {
        $userName = UserName::build('UserTest');

        self::assertInstanceOf(UserName::class, $userName);
        self::assertEquals('UserTest', $userName->value());
    }

}
