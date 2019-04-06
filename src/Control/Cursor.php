<?php declare(strict_types=1);

namespace AlecRabbit\Control;

use AlecRabbit\ConsoleColour\ConsoleColor;

class Cursor
{
    public static function show(): string
    {
        return ConsoleColor::ESC_CHAR . '[?25h' . ConsoleColor::ESC_CHAR . '[?0c';
    }

    public static function hide(): string
    {
        return ConsoleColor::ESC_CHAR . '[?25l';
    }
}
