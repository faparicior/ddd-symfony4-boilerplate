<?php

namespace App\Shared\Domain\Service;

interface UniqueIdProviderInterface
{
    /**
     * @return string
     * @throws \Exception
     */
    public function generate(): string;
}
