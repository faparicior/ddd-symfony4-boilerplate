<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Domain\Specifications;

use App\Users\User\Domain\Specifications\StringNotEmpty;
use PHPUnit\Framework\TestCase;

class StringNotEmptyTest extends TestCase
{
    private const VALID_STRING = '12345678';
    private const INVALID_STRING = '';
    private const SPECIFICATION_FAIL_MESSAGE = 'String value empty';

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testStringNotEmptyCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new StringNotEmpty();
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testStringNotEmptyValidationReturnsTrue()
    {
        $specification = StringNotEmpty::build();

        self::assertTrue($specification->isSatisfiedBy(self::VALID_STRING));
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testStringNotEmptyValidationReturnsFalse()
    {
        $specification = StringNotEmpty::build();

        self::assertFalse($specification->isSatisfiedBy(self::INVALID_STRING));
    }

    public function testUsernameExistsReturnsExpectedFailedMessage()
    {
        $specification = StringNotEmpty::build();
        self::assertEquals(self::SPECIFICATION_FAIL_MESSAGE, $specification->getFailedMessage());
    }
}
