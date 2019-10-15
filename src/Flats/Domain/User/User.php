<?php declare(strict_types=1);

namespace App\Flats\Domain\User;

final class User
{
    private function __construct()
    {

    }

    public static function build()
    {
        return new static();
    }
}
