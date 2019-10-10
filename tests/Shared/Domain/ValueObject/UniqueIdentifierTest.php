<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\InvalidArgumentException;
use App\Shared\Domain\ValueObject\UniqueIdentifier;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UniqueIdentifierTest extends TestCase
{
    private const USER_ID = '00000000-0000-4000-8000-000000000000';
    private const INVALID_USER_ID = '00000000-0000-5000-8000-000000000000';

    public function testUniqueIdentifierCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new UniqueIdentifier();
    }

    /**
     * @group Shared
     * @group Domain
     * @throws \Exception
     */
    public function testUserIdCanBeCreated()
    {
        $userName = UniqueIdentifier::build();

        self::assertInstanceOf(UniqueIdentifier::class, $userName);
    }

    /**
     * @group Shared
     * @group Domain
     *
     * @throws InvalidArgumentException
     */
    public function testUserIdCanBeCreatedFromString()
    {
        $userId = UniqueIdentifier::fromString(self::USER_ID);
        $regex = "/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/";

        self::assertEquals(1, preg_match($regex, $userId->value()));
    }

    /**
     * @group Shared
     * @group Domain
     *
     * @throws \Exception
     */
    public function testTwoNewUserIdHaveDifferentValues()
    {
        $firstUserId = UniqueIdentifier::build();
        $secondUserId = UniqueIdentifier::build();

        self::assertNotEquals($firstUserId->value(), $secondUserId->value());
    }

    /**
     * @group Shared
     * @group Domain
     *
     * @throws InvalidArgumentException
     */
    public function testCreateUserIdFailsForBadStringFormat()
    {
        self::expectException(InvalidArgumentException::class);
        UniqueIdentifier::fromString(self::INVALID_USER_ID);
    }
}
