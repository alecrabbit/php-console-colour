<?php declare(strict_types=1);

namespace AlecRabbit\Control;

use AlecRabbit\ConsoleColour\ConsoleColor;

class Cursor
{
    protected const ESC = ConsoleColor::ESC_CHAR;

    /**
     * Show cursor sequence
     *
     * @return string
     */
    public static function show(): string
    {
        return self::ESC . '[?25h' . self::ESC . '[?0c';
    }

    /**
     * Hide cursor sequence
     *
     * @return string
     */
    public static function hide(): string
    {
        return self::ESC . '[?25l';
    }

    /**
     * Move cursor up sequence
     *
     * @param int $rows
     * @return string
     */
    public static function up(int $rows = 1): string
    {
        return self::ESC . "[{$rows}A";
    }

    /**
     * Move cursor down sequence
     *
     * @param int $rows
     * @return string
     */
    public static function down(int $rows = 1): string
    {
        return self::ESC . "[{$rows}B";
    }

    /**
     * Move cursor forward sequence
     *
     * @param int $cols
     * @return string
     */
    public static function forward(int $cols = 1): string
    {
        return self::ESC . "[{$cols}C";
    }

    /**
     * Move cursor back sequence
     *
     * @param int $cols
     * @return string
     */
    public static function back(int $cols = 1): string
    {
        return self::ESC . "[{$cols}D";
    }

    /**
     * Move cursor to sequence
     *
     * @param int $col
     * @param int $row
     * @return string
     */
    public static function goTo(int $col = 1, int $row = 1): string
    {
        return self::ESC . "[{$row};{$col}f";
    }

    /**
     * Save cursor position sequence
     *
     * @return string
     */
    public static function savePosition(): string
    {
        return self::ESC . '[s';
    }

    /**
     * Restore cursor position sequence
     *
     * @return string
     */
    public static function restorePosition(): string
    {
        return self::ESC . '[u';
    }
    /**
     * Save cursor position and attributes sequence
     *
     * @return string
     */
    public static function save(): string
    {
        return self::ESC . '7';
    }

    /**
     * Restore cursor position and attributes sequence
     *
     * @return string
     */
    public static function restore(): string
    {
        return self::ESC . '8';
    }
}
//
