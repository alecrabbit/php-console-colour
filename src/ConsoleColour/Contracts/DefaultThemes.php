<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Contracts;

interface DefaultThemes
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
        self::ITALIC => 'italic',
        self::DARK => 'dark',
        self::DARK_ITALIC => ['dark', 'italic'],
        self::WHITE => 'white',
        self::WHITE_BOLD => ['white', 'bold'],
        self::COMMENT => 'yellow',
        self::YELLOW => 'yellow',
        self::GREEN => 'green',
        self::ERROR => ['white', 'bold', 'bg_red'],
        self::RED => 'red',
        self::INFO => 'green',
        self::UNDERLINE => ['underline'],
        self::UNDERLINE_BOLD => ['underline', 'bold'],
        self::UNDERLINE_ITALIC => ['underline', 'italic'],
    ];
}
