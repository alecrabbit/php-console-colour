<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Color;

use AlecRabbit\Cli\Tools\Core\Terminal;
use AlecRabbit\Console\Color\Core\TerminalColor;
use AlecRabbit\Console\Contracts\ColorInterface;
use AlecRabbit\Console\Style\Style;

use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\NO_COLOR_TERMINAL;

final class Color implements ColorInterface
{
    /**
     * @var TerminalColor
     */
    private $terminalColor;

    /**
     * ConsoleColor constructor.
     * @param null|bool|resource $stream
     * @param null|int $colorLevel
     */
    public function __construct($stream = null, ?int $colorLevel = null)
    {
        $this->terminalColor = TerminalColor::create($stream, $colorLevel);
    }

    public function apply(Style $style, $string): string
    {
        if(!$this->terminalColor->isEnabled()) {
            return $string;
        }
        return $style->render($string, $this->terminalColor);
    }
}