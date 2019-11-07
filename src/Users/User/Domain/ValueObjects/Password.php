<?php declare(strict_types=1);

namespace App\Users\User\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\InvalidStringException;
use App\Shared\Domain\Specifications\StringSpecificationChain;
use App\Shared\Domain\ValueObjects\StringValue;
use App\Users\User\Domain\Exceptions\PasswordNotValidByPolicyRules;
use App\Users\User\Domain\Specifications\StringMoreThanSevenCharacters;

class Password extends StringValue
{
    /**
     * @param string $value
     * @return StringValue|Password
     * @throws PasswordNotValidByPolicyRules
     */
    public static function build(string $value)
    {
        try {
            $password = new static($value, self::specificationChain());
        } catch (InvalidStringException $exception)
        {
            throw PasswordNotValidByPolicyRules::build();
        }

        return $password;
    }

    private static function specificationChain(): ?StringSpecificationChain
    {
        return StringSpecificationChain::build(...[StringMoreThanSevenCharacters::build()]);
    }
}
