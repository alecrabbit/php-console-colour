<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Color\Core;

class MultiColorFactory
{
    /**
     * @param mixed $color
     * @return MultiColor
     */
    public static function create($color): MultiColor
    {
        return new MultiColor($color);
    }
}