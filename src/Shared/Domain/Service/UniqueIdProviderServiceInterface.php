<?php

namespace App\Shared\Domain\Service;

interface UniqueIdProviderServiceInterface
{

    /**
     * @return string
     * @throws \Exception
     */
    public function generate(): string;
}
