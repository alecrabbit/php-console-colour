<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Color\Core;

use const AlecRabbit\COLOR256_TERMINAL;

final class Support
{
    public static function get(): int
    {
        return COLOR256_TERMINAL;
    }

    public static function set(): int
    {
        return COLOR256_TERMINAL;
    }
}