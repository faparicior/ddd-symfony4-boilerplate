<?php

namespace App\Shared\Infrastructure\Services;

use Exception;

interface UniqueIdProviderInterface
{
    /**
     * @throws Exception
     */
    public function generate(): string;
}
