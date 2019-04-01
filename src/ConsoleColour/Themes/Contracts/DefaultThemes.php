<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Themes\Contracts;

interface DefaultThemes
{
    // These strings are used as methods names
    public const DEBUG = 'debug';
    public const COMMENT = 'comment';
    public const INFO = 'info';
    public const ERROR = 'error';

    public const YELLOW = 'yellow';
    public const GREEN = 'green';
    public const RED = 'red';
    public const CYAN = 'cyan';
    public const MAGENTA = 'magenta';

    public const ITALIC = 'italic';
    public const BOLD = 'bold';
    public const DARK = 'dark';
    public const DARK_ITALIC = 'darkItalic';
    public const WHITE = 'white';
    public const WHITE_BOLD = 'whiteBold';
    public const UNDERLINED = 'underlined';
    public const UNDERLINED_BOLD = 'underlinedBold';
    public const UNDERLINED_ITALIC = 'underlinedItalic';
}
