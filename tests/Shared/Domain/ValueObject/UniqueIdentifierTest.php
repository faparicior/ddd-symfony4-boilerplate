<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\InvalidArgumentException;
use App\Shared\Domain\ValueObject\UniqueIdentifier;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UniqueIdentifierForTest extends UniqueIdentifier
{

}

class UniqueIdentifierTest extends TestCase
{
    private const USER_ID = '00000000-0000-4000-8000-000000000000';
    private const USER_ID_DIFFERENT = '00000000-0000-4000-8000-000000000001';
    private const INVALID_USER_ID = '00000000-0000-5000-8000-000000000000';

    public function testUniqueIdentifierCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new UniqueIdentifierForTest();
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \Exception
     */
    public function testUserIdCanBeCreated()
    {
        $userName = UniqueIdentifierForTest::build();

        self::assertInstanceOf(UniqueIdentifierForTest::class, $userName);
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws InvalidArgumentException
     */
    public function testUserIdCanBeCreatedFromString()
    {
        $userId = UniqueIdentifierForTest::fromString(self::USER_ID);
        $regex = "/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/";

        self::assertEquals(1, preg_match($regex, $userId->value()));
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws \Exception
     */
    public function testTwoNewUserIdHaveDifferentValues()
    {
        $firstUserId = UniqueIdentifierForTest::build();
        $secondUserId = UniqueIdentifierForTest::build();

        self::assertNotEquals($firstUserId->value(), $secondUserId->value());
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws InvalidArgumentException
     */
    public function testCreateUserIdFailsForBadStringFormat()
    {
        self::expectException(InvalidArgumentException::class);
        UniqueIdentifierForTest::fromString(self::INVALID_USER_ID);
    }

    /**
     * @group UnitTests
     * @group Shared
     * @group Domain
     *
     * @throws InvalidArgumentException
     */
    public function testEqualsFunction()
    {
        $integer = UniqueIdentifierForTest::fromString(self::USER_ID);

        self::assertTrue($integer->equals(UniqueIdentifierForTest::fromString(self::USER_ID)));
        self::assertFalse($integer->equals(UniqueIdentifierForTest::fromString(self::USER_ID_DIFFERENT)));
    }
}
