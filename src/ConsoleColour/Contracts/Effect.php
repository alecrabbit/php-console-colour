<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Contracts;

interface Effect
{
    public const RESET = 0;
    public const NONE = 1;
    public const BOLD = 2;
    public const DARK = 3;
    public const ITALIC = 4;
    public const UNDERLINE = 5;
    public const BLINK = 6;
    public const BLINK_FAST = 7; // Limited support
    public const REVERSE = 8;
    public const CONCEALED = 9;
}
