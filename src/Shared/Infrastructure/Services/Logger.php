<?php

namespace App\Shared\Infrastructure\Services;

use Monolog\Formatter\LogglyFormatter;

class Logger
{
    public function __construct()
    {
        new LogglyFormatter()
    }
}