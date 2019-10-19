<?php declare(strict_types=1);

namespace App\Tests\Users\User\Domain\ValueObject;

use App\Users\User\Domain\ValueObject\UserName;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserNameTest extends TestCase
{
    /**
     * @group Users
     * @group Domain
     */
    public function testUserNameCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new UserName();
    }

    /**
     * @group Users
     * @group Domain
     */    public function testUserNameCanBeBuilt()
    {
        $userName = UserName::build('UserTest');

        self::assertInstanceOf(UserName::class, $userName);
        self::assertEquals('UserTest', $userName->value());
    }

}
