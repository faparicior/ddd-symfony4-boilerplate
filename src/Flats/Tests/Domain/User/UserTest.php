<?php declare(strict_types=1);

namespace App\Flats\Tests\Domain\User;

use App\Flats\Domain\User\User;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @group Flats
     * @group Domain
     */
    public function testUserCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new User();
    }

    /**
     * @group Flats
     * @group Domain
     */
    public function testUserCanBeBuilt()
    {
        $user = User::build();

        self::assertInstanceOf(User::class, $user);
    }

}
