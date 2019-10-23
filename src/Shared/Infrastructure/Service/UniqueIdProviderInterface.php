<?php

namespace App\Shared\Infrastructure\Service;

interface UniqueIdProviderInterface
{
    /**
     * @return string
     * @throws \Exception
     */
    public function generate(): string;
}
