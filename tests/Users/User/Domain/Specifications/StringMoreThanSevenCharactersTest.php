<?php declare(strict_types=1);

namespace App\Tests\Users\User\Domain\Specifications;

use App\Users\User\Domain\Specifications\StringMoreThanSevenCharacters;
use PHPUnit\Framework\TestCase;

class StringMoreThanSevenCharactersTest extends TestCase
{
    const VALID_STRING = '12345678';
    const INVALID_STRING = '1234567';

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testMoreThanSevenCharactersCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new StringMoreThanSevenCharacters();
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testMoreThanSevenCharactersValidationReturnsTrue()
    {
        $specification = StringMoreThanSevenCharacters::build();

        self::assertTrue($specification->isSatisfiedBy(self::VALID_STRING));
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Domain
     */
    public function testMoreThanSevenCharactersValidationReturnsFalse()
    {
        $specification = StringMoreThanSevenCharacters::build();

        self::assertFalse($specification->isSatisfiedBy(self::INVALID_STRING));
    }
}