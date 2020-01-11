<?php declare(strict_types=1);

namespace App\Users\User\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\InvalidStringException;
use App\Shared\Domain\Specifications\StringSpecificationChain;
use App\Shared\Domain\ValueObjects\StringValue;
use App\Users\User\Domain\Exceptions\UserNameInvalidByPolicyRules;
use App\Users\User\Domain\Specifications\StringNotEmpty;

class UserName extends StringValue
{
    public const INVALID_BY_POLICY_RULES = "Username invalid by policy rules";

    /**
     * @param string $value
     * @return StringValue|Password
     * @throws UserNameInvalidByPolicyRules
     */
    public static function build(string $value)
    {
        try {
            $password = new static($value, self::specificationChain());
        } catch (InvalidStringException $exception)
        {
            throw UserNameInvalidByPolicyRules::build(self::INVALID_BY_POLICY_RULES);
        }

        return $password;
    }

    private static function specificationChain(): ?StringSpecificationChain
    {
        return StringSpecificationChain::build(...[StringNotEmpty::build()]);
    }
}
