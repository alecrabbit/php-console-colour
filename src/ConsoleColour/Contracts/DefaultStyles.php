<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Contracts;

use AlecRabbit\ConsoleColour\Contracts\Styles as Style;

interface DefaultStyles
{
    // These strings are used as methods names
    public const ITALIC = 'italic';
    public const BOLD = 'bold';
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
    public const UNDERLINED = 'underlined';
    public const UNDERLINED_BOLD = 'underlinedBold';
    public const UNDERLINED_ITALIC = 'underlinedItalic';

    public const STYLES = [
        // name => [styles],
        self::ITALIC => Style::ITALIC,
        self::BOLD => Style::BOLD,
        self::DARK => Style::DARK,
        self::DARK_ITALIC => [Style::DARK, Style::ITALIC],
        self::WHITE => Style::WHITE,
        self::WHITE_BOLD => [Style::WHITE, Style::BOLD],
        self::COMMENT => Style::YELLOW,
        self::YELLOW => Style::YELLOW,
        self::GREEN => Style::GREEN,
        self::ERROR => [Style::WHITE, Style::BOLD, Style::BG_RED],
        self::RED => Style::RED,
        self::INFO => Style::GREEN,
        self::UNDERLINED => [Style::UNDERLINE],
        self::UNDERLINED_BOLD => [Style::UNDERLINE, Style::BOLD],
        self::UNDERLINED_ITALIC => [Style::UNDERLINE, Style::ITALIC],
    ];
}
