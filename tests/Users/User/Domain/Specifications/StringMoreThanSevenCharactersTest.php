<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Domain\Specifications;

use App\Users\User\Domain\Specifications\StringMoreThanSevenCharacters;
use PHPUnit\Framework\TestCase;

class StringMoreThanSevenCharactersTest extends TestCase
{
    private const VALID_STRING = '12345678';
    private const INVALID_STRING = '1234567';
    private const SPECIFICATION_FAIL_MESSAGE = 'String less than 8 characters';

    public function testMoreThanSevenCharactersCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new StringMoreThanSevenCharacters();
    }

    public function testMoreThanSevenCharactersValidationReturnsTrue()
    {
        $specification = StringMoreThanSevenCharacters::build();

        self::assertTrue($specification->isSatisfiedBy(self::VALID_STRING));
    }

    public function testMoreThanSevenCharactersValidationReturnsFalse()
    {
        $specification = StringMoreThanSevenCharacters::build();

        self::assertFalse($specification->isSatisfiedBy(self::INVALID_STRING));
    }

    public function testMoreThanSevenCharactersReturnsExpectedFailedMessage()
    {
        $specification = StringMoreThanSevenCharacters::build();
        self::assertEquals(self::SPECIFICATION_FAIL_MESSAGE, $specification->getFailedMessage());
    }
}
