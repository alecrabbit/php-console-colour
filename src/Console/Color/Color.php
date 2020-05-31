<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Color;

use AlecRabbit\Console\Color\Core\TerminalColor;
use AlecRabbit\Console\Contracts\ColorInterface;
use AlecRabbit\Console\Style\Style;

use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\NO_COLOR_TERMINAL;

final class Color implements ColorInterface
{
    /** @var int */
    private $colorLevel = NO_COLOR_TERMINAL;
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
        if($this->terminalColor->isEnabled()) {
            $this->colorLevel = $this->terminalColor->getLevel();
        }
    }

    public function apply(Style $style, string $string): string
    {
        if ($this->colorLevel < COLOR_TERMINAL) {
            return $string;
        }
        return
            sprintf(
                $style->templateFor($this->colorLevel),
                $string
            );
    }

    /**
     * @return TerminalColor
     */
    public function getTerminalColor(): TerminalColor
    {
        return $this->terminalColor;
    }
}