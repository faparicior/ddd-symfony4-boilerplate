<?php

namespace App\Shared\Infrastructure\Services;

use Exception;

interface UniqueIdProviderInterface
{
    /**
     * @return string
     * @throws Exception
     */
    public function generate(): string;
}
