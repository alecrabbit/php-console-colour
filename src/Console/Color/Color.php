<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Color;

use AlecRabbit\Console\Contracts\ColorInterface;
use AlecRabbit\Console\Style\Style;

use const AlecRabbit\COLOR256_TERMINAL;

final class Color implements ColorInterface
{
    /**
     * @var int
     */
    private $terminalColor;

    public function __construct($terminalColor = COLOR256_TERMINAL)
    {
        $this->terminalColor = $terminalColor;
    }

    public function apply(Style $style, $string): string
    {
        return $style->render($string, $this->terminalColor);
    }
}