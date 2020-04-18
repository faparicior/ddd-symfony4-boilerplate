<?php declare(strict_types=1);

namespace App\Users\User\Infrastructure\Persistence\Mappings\Types;

use App\Shared\Domain\Exceptions\DomainException;
use App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRulesException;
use App\Users\User\Domain\ValueObjects\UserName;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use ReflectionException;

class UserNameType extends Type
{
    public const MY_TYPE = "UserName";

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
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws DomainException
     * @throws UserNameInvalidByPolicyRulesException
     * @throws ReflectionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return parent::convertToPHPValue(UserName::build($value), $platform);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValue($value->__toString(), $platform);
    }
}
