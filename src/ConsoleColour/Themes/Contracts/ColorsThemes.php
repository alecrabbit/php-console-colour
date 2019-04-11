<?php declare(strict_types=1);


namespace AlecRabbit\ConsoleColour\Themes\Contracts;

use AlecRabbit\ConsoleColour\Contracts\Color;

interface ColorsThemes
{
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

    public const COLORS = [
        self::BLACK => Color::BLACK,
        self::YELLOW => Color::YELLOW,
        self::GREEN => Color::GREEN,
        self::RED => Color::RED,
        self::CYAN => Color::CYAN,
        self::MAGENTA => Color::MAGENTA,
        self::BLUE => Color::BLUE,
        self::LIGHT_GRAY => Color::LIGHT_GRAY,
        self::DARK_GRAY => Color::DARK_GRAY,
        self::LIGHT_RED => Color::LIGHT_RED,
        self::LIGHT_GREEN => Color::LIGHT_GREEN,
        self::LIGHT_YELLOW => Color::LIGHT_YELLOW,
        self::LIGHT_BLUE => Color::LIGHT_BLUE,
        self::LIGHT_MAGENTA => Color::LIGHT_MAGENTA,
        self::LIGHT_CYAN => Color::LIGHT_CYAN,
        self::WHITE => Color::WHITE,
    ];
}
