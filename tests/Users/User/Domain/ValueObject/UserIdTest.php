<?php declare(strict_types=1);

namespace App\Tests\Users\User\Domain\ValueObject;

use App\Users\User\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserIdTest extends TestCase
{
    private const USER_ID = '00000000-0000-4000-8000-000000000000';

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testUserIdCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new UserId();
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testUserIdCanBeBuilt()
    {
        $regex = "/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/";

        $userId = UserId::build(self::USER_ID);

        self::assertInstanceOf(UserId::class, $userId);
        self::assertEquals(1, preg_match($regex, $userId->value()));
    }
}
