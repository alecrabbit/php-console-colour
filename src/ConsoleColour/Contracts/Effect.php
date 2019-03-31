<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Contracts;

interface Effect
{
    public const NONE = 0;
    public const BOLD = 1;
    public const DARK = 2;
    public const ITALIC = 3;
    public const UNDERLINE = 4;
    public const BLINK = 5;
    public const BLINK_FAST = 6; // Limited support
    public const REVERSE = 7;
    public const CONCEALED = 8;
    public const CROSSED_OUT = 9;

    public const DOUBLE_UNDERLINE = 21;
}
