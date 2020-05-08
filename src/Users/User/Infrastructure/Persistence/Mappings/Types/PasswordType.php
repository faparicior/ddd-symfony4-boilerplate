<?php

declare(strict_types=1);

namespace App\Users\User\Infrastructure\Persistence\Mappings\Types;

use App\Shared\Domain\Exceptions\DomainException;
use App\Users\User\Domain\Exceptions\PasswordInvalidByPolicyRulesException;
use App\Users\User\Domain\ValueObjects\Password;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use ReflectionException;

class PasswordType extends Type
{
    public const MY_TYPE = 'Password';

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
     * @throws ReflectionException
     * @throws PasswordInvalidByPolicyRulesException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return parent::convertToPHPValue(Password::build($value), $platform);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValue($value->__toString(), $platform);
    }
}
