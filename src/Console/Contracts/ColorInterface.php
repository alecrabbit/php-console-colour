<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Contracts;

use AlecRabbit\Console\Style\Style;

/**
 * Interface ColorInterface
 */
interface ColorInterface
{

    /**
     * @param Style $style
     * @param string $string
     * @return string
     */
    public function apply(Style $style, string $string): string;
}