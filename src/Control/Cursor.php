<?php declare(strict_types=1);

namespace AlecRabbit\Control;

use AlecRabbit\ConsoleColour\ConsoleColor;

class Cursor
{
    /**
     * Show cursor sequence
     *
     * @return string
     */
    public static function show(): string
    {
        return ConsoleColor::ESC_CHAR . '[?25h' . ConsoleColor::ESC_CHAR . '[?0c';
    }

    /**
     * Hide cursor sequence
     *
     * @return string
     */
    public static function hide(): string
    {
        return ConsoleColor::ESC_CHAR . '[?25l';
    }

    /**
     * Move up cursor sequence
     *
     * @param int $rows
     * @return string
     */
    public static function up(int $rows = 1): string
    {
        return ConsoleColor::ESC_CHAR .  "[{$rows}A";
    }

    /**
     * Move down cursor sequence
     *
     * @param int $rows
     * @return string
     */
    public static function down(int $rows = 1): string
    {
        return ConsoleColor::ESC_CHAR .  "[{$rows}B";
    }
}
