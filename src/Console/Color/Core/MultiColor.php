<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Color\Core;

use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\CSI;
use const AlecRabbit\NO_COLOR_TERMINAL;
use const AlecRabbit\TRUECOLOR_TERMINAL;

class MultiColor
{
    private $color;

    public function __construct($color)
    {
//        $this->assertColor($color);
        $this->color16 = "\x1b[31m";
        $this->color256 = "\x1b[38;5;165m";
        $this->truecolor = "\x1b[38;2;255;0;0m";
    }

    /**
     * @param mixed $color
     */
    private function assertColor($color): void
    {
        // TODO
    }

    /**
     * @param TerminalColor $terminalColor
     * @return string
     */
    public function getSequence(TerminalColor $terminalColor): string
    {
        $level = $terminalColor->getLevel();
        switch ($level) {
            case TRUECOLOR_TERMINAL:
                return $this->truecolor;
                break;
            case COLOR256_TERMINAL:
                return $this->color256;
                break;
            case COLOR_TERMINAL:
                return $this->color16;
                break;
        }
        return '';
    }

    /**
     * @param string $value
     * @return string
     */
    protected function escSequence(string $value): string
    {
        return
            CSI . $value . 'm';
    }


}