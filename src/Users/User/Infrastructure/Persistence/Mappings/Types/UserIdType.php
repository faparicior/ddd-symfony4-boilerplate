<?php declare(strict_types=1);

namespace App\Users\User\Infrastructure\Persistence\Mappings\Types;

use App\Users\User\Domain\ValueObjects\UserId;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Exception;

class UserIdType extends Type
{
    public const MY_TYPE = "UserId";

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
     * @throws Exception
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return parent::convertToPHPValue(UserId::fromString($value), $platform);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValue($value->__toString(), $platform);
    }
}
