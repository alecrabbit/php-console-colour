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

    public const BLACK = 'black';
    public const BLUE = 'blue';
    public const LIGHT_GRAY = 'lightGray';
    public const DARK_GRAY = 'darkGray';
    public const LIGHT_RED = 'lightRed';
    public const LIGHT_GREEN = 'lightGreen';
    public const LIGHT_YELLOW = 'lightYellow';
    public const LIGHT_BLUE = 'lightBlue';
    public const LIGHT_MAGENTA = 'lightMagenta';
    public const LIGHT_CYAN = 'lightCyan';
    public const WHITE = 'white';

    public const ITALIC = 'italic';
    public const BOLD = 'bold';
    public const DARK = 'dark';
    public const CROSSED = 'crossed';
    public const DARK_ITALIC = 'darkItalic';
    public const WHITE_BOLD = 'whiteBold';
    public const UNDERLINED = 'underlined';
    public const UNDERLINED_BOLD = 'underlinedBold';
    public const UNDERLINED_ITALIC = 'underlinedItalic';
}