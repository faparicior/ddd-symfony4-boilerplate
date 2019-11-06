<?php

namespace App\Shared\Infrastructure\Services;

interface UniqueIdProviderInterface
{
    /**
     * @return string
     * @throws \Exception
     */
    public function generate(): string;
}
