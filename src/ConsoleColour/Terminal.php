<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour;

use AlecRabbit\ConsoleColour\Contracts\TerminalInterface;

/**
 * Class Terminal
 * @author AlecRabbit
 */
class Terminal extends AbstractTerminal implements TerminalInterface
{

    /** {@inheritdoc} */
    public function width(bool $recheck = false): int
    {
        if (null !== static::$width && true !== $recheck) {
            return static::$width;
        }
        return
            static::$width = $this->getWidth();
    }


    /** {@inheritdoc} */
    public function height(bool $recheck = false): int
    {
        if (null !== static::$height && true !== $recheck) {
            return static::$height;
        }
        return
            static::$height = $this->getHeight();
    }

    /** {@inheritdoc} */
    public function supports256Color(bool $recheck = false): bool
    {
        if (null !== static::$supports256Color && true !== $recheck) {
            return static::$supports256Color;
        }
        return
            static::$supports256Color = $this->check256ColorSupport();
    }

    /** {@inheritdoc} */
    public function supportsColor(bool $recheck = false): bool
    {
        if (null !== static::$supportsColor && true !== $recheck) {
            return static::$supportsColor;
        }
        return
            static::$supportsColor = $this->hasColorSupport();
    }
}
