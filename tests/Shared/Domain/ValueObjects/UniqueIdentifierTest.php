<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\DomainException;
use App\Shared\Domain\Exceptions\InvalidArgumentException;
use App\Shared\Domain\ValueObjects\UniqueIdentifier;
use Exception;
use PHPUnit\Framework\TestCase;

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
     * @throws Exception
     */
    public function testUserIdCanBeCreated()
    {
        $userName = UniqueIdentifierForTest::build();

        self::assertInstanceOf(UniqueIdentifierForTest::class, $userName);
    }

    /**
     * @throws DomainException
     */
    public function testUserIdCanBeCreatedFromString()
    {
        $userId = UniqueIdentifierForTest::fromString(self::USER_ID);
        $regex = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';

        self::assertEquals(1, preg_match($regex, $userId->value()));
    }

    /**
     * @throws Exception
     */
    public function testTwoNewUserIdHaveDifferentValues()
    {
        $firstUserId = UniqueIdentifierForTest::build();
        $secondUserId = UniqueIdentifierForTest::build();

        self::assertNotEquals($firstUserId->value(), $secondUserId->value());
    }

    /**
     * @throws DomainException
     */
    public function testCreateUserIdFailsForBadStringFormat()
    {
        self::expectException(InvalidArgumentException::class);
        UniqueIdentifierForTest::fromString(self::INVALID_USER_ID);
    }

    /**
     * @throws DomainException
     */
    public function testEqualsFunction()
    {
        $uuid = UniqueIdentifierForTest::fromString(self::USER_ID);

        self::assertTrue($uuid->equals(UniqueIdentifierForTest::fromString(self::USER_ID)));
        self::assertFalse($uuid->equals(UniqueIdentifierForTest::fromString(self::USER_ID_DIFFERENT)));
    }

    /**
     * @throws DomainException
     */
    public function testHasToStringMagicFunction()
    {
        $uuid = UniqueIdentifierForTest::fromString(self::USER_ID);

        self::assertEquals(self::USER_ID, $uuid->__toString());
    }
}
