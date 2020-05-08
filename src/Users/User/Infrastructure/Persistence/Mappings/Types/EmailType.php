<?php

declare(strict_types=1);

namespace App\Users\User\Infrastructure\Persistence\Mappings\Types;

use App\Shared\Domain\Exceptions\DomainException;
use App\Shared\Domain\Exceptions\InvalidEmailException;
use App\Users\User\Domain\ValueObjects\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class EmailType extends Type
{
    public const MY_TYPE = 'Email';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        // TODO: Implement getSQLDeclaration() method.
    }

    public function getName()
    {
        return self::MY_TYPE;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     *
     * @throws DomainException
     * @throws InvalidEmailException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return parent::convertToPHPValue(Email::build($value), $platform);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValue($value->__toString(), $platform);
    }
}
