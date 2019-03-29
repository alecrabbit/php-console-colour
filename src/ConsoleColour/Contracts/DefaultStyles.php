<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Contracts;

use AlecRabbit\ConsoleColour\Contracts\StylesInterface as Styles;

interface DefaultStyles
{
    // These strings are used as methods names
    public const ITALIC = 'italic';
    public const DARK = 'dark';
    public const DARK_ITALIC = 'darkItalic';
    public const WHITE = 'white';
    public const WHITE_BOLD = 'whiteBold';
    public const COMMENT = 'comment';
    public const YELLOW = 'yellow';
    public const GREEN = 'green';
    public const ERROR = 'error';
    public const RED = 'red';
    public const INFO = 'info';
    public const UNDERLINE = 'underline';
    public const UNDERLINE_BOLD = 'underlineBold';
    public const UNDERLINE_ITALIC = 'underlineItalic';

    public const THEMES = [
        // name => [styles],
        self::ITALIC => Styles::ITALIC,
        self::DARK => Styles::DARK,
        self::DARK_ITALIC => [Styles::DARK, Styles::ITALIC],
        self::WHITE => Styles::WHITE,
        self::WHITE_BOLD => [Styles::WHITE, Styles::BOLD],
        self::COMMENT => Styles::YELLOW,
        self::YELLOW => Styles::YELLOW,
        self::GREEN => Styles::GREEN,
        self::ERROR => [Styles::WHITE, Styles::BOLD, Styles::BG_RED],
        self::RED => Styles::RED,
        self::INFO => Styles::GREEN,
        self::UNDERLINE => [Styles::UNDERLINE],
        self::UNDERLINE_BOLD => [Styles::UNDERLINE, Styles::BOLD],
        self::UNDERLINE_ITALIC => [Styles::UNDERLINE, Styles::ITALIC],
    ];
}
