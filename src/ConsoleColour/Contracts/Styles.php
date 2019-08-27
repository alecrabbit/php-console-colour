<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Contracts;

interface Styles
{
    public const BG = 'bg_';
    public const COLOR256_REGEXP = '~^(bg_)?color_(\d{1,3})$~';

    public const RESET = 0;
    public const FOREGROUND = 38;
    public const BACKGROUND = 48;

    public const NONE = Effect::NONE;
    public const BOLD = Effect::BOLD;
    public const DARK = Effect::DARK;
    public const ITALIC = Effect::ITALIC;
    public const UNDERLINE = Effect::UNDERLINE;
    public const BLINK = Effect::BLINK;
    public const BLINK_FAST = Effect::BLINK_FAST; // Limited support
    public const REVERSE = Effect::REVERSE;
    public const CONCEALED = Effect::CONCEALED;
    public const CROSSED_OUT = Effect::CROSSED_OUT;
    public const DOUBLE_UNDERLINE = Effect::DOUBLE_UNDERLINE;

    public const DEFAULT_COLOR = Color::DEFAULT_COLOR;
    public const BLACK = Color::BLACK;
    public const RED = Color::RED;
    public const GREEN = Color::GREEN;
    public const YELLOW = Color::YELLOW;
    public const BLUE = Color::BLUE;
    public const MAGENTA = Color::MAGENTA;
    public const CYAN = Color::CYAN;
    public const LIGHT_GRAY = Color::LIGHT_GRAY;

    public const DARK_GRAY = Color::DARK_GRAY;
    public const LIGHT_RED = Color::LIGHT_RED;
    public const LIGHT_GREEN = Color::LIGHT_GREEN;
    public const LIGHT_YELLOW = Color::LIGHT_YELLOW;
    public const LIGHT_BLUE = Color::LIGHT_BLUE;
    public const LIGHT_MAGENTA = Color::LIGHT_MAGENTA;
    public const LIGHT_CYAN = Color::LIGHT_CYAN;
    public const WHITE = Color::WHITE;

    public const BG_DEFAULT = BG::DEFAULT_BG;
    public const BG_BLACK = BG::BLACK;
    public const BG_RED = BG::RED;
    public const BG_GREEN = BG::GREEN;
    public const BG_YELLOW = BG::YELLOW;
    public const BG_BLUE = BG::BLUE;
    public const BG_MAGENTA = BG::MAGENTA;
    public const BG_CYAN = BG::CYAN;
    public const BG_LIGHT_GRAY = BG::LIGHT_GRAY;

    public const BG_DARK_GRAY = BG::DARK_GRAY;
    public const BG_LIGHT_RED = BG::LIGHT_RED;
    public const BG_LIGHT_GREEN = BG::LIGHT_GREEN;
    public const BG_LIGHT_YELLOW = BG::LIGHT_YELLOW;
    public const BG_LIGHT_BLUE = BG::LIGHT_BLUE;
    public const BG_LIGHT_MAGENTA = BG::LIGHT_MAGENTA;
    public const BG_LIGHT_CYAN = BG::LIGHT_CYAN;
    public const BG_WHITE = BG::WHITE;

    public const CODES =
        [
            self::NONE => null,
            self::BOLD => '1',
            self::DARK => '2',
            self::ITALIC => '3',
            self::UNDERLINE => '4',
            self::BLINK => '5',
            self::BLINK_FAST => '6', // Limited support
            self::REVERSE => '7',
            self::CONCEALED => '8',
            self::CROSSED_OUT => '9',

            self::DOUBLE_UNDERLINE => '21',

            self::BLACK => '30',
            self::RED => '31',
            self::GREEN => '32',
            self::YELLOW => '33',
            self::BLUE => '34',
            self::MAGENTA => '35',
            self::CYAN => '36',
            self::LIGHT_GRAY => '37',
            self::DEFAULT_COLOR => '39',

            self::DARK_GRAY => '90',
            self::LIGHT_RED => '91',
            self::LIGHT_GREEN => '92',
            self::LIGHT_YELLOW => '93',
            self::LIGHT_BLUE => '94',
            self::LIGHT_MAGENTA => '95',
            self::LIGHT_CYAN => '96',
            self::WHITE => '97',

            self::BG_DEFAULT => '49',
            self::BG_BLACK => '40',
            self::BG_RED => '41',
            self::BG_GREEN => '42',
            self::BG_YELLOW => '43',
            self::BG_BLUE => '44',
            self::BG_MAGENTA => '45',
            self::BG_CYAN => '46',
            self::BG_LIGHT_GRAY => '47',

            self::BG_DARK_GRAY => '100',
            self::BG_LIGHT_RED => '101',
            self::BG_LIGHT_GREEN => '102',
            self::BG_LIGHT_YELLOW => '103',
            self::BG_LIGHT_BLUE => '104',
            self::BG_LIGHT_MAGENTA => '105',
            self::BG_LIGHT_CYAN => '106',
            self::BG_WHITE => '107',
        ];

    public const NAMES =
        [
            self::NONE => 'NONE',
            self::BOLD => 'BOLD',
            self::DARK => 'DARK',
            self::ITALIC => 'ITALIC',
            self::UNDERLINE => 'UNDERLINE',
            self::BLINK => 'BLINK',
            self::BLINK_FAST => 'BLINK_FAST',
            self::REVERSE => 'REVERSE',
            self::CONCEALED => 'CONCEALED',
            self::CROSSED_OUT => 'CROSSED_OUT',
            self::DOUBLE_UNDERLINE => 'DOUBLE_UNDERLINE',
            self::DEFAULT_COLOR => 'DEFAULT_COLOR',
            self::BLACK => 'BLACK',
            self::RED => 'RED',
            self::GREEN => 'GREEN',
            self::YELLOW => 'YELLOW',
            self::BLUE => 'BLUE',
            self::MAGENTA => 'MAGENTA',
            self::CYAN => 'CYAN',
            self::LIGHT_GRAY => 'LIGHT_GRAY',
            self::DARK_GRAY => 'DARK_GRAY',
            self::LIGHT_RED => 'LIGHT_RED',
            self::LIGHT_GREEN => 'LIGHT_GREEN',
            self::LIGHT_YELLOW => 'LIGHT_YELLOW',
            self::LIGHT_BLUE => 'LIGHT_BLUE',
            self::LIGHT_MAGENTA => 'LIGHT_MAGENTA',
            self::LIGHT_CYAN => 'LIGHT_CYAN',
            self::WHITE => 'WHITE',
            self::BG_DEFAULT => 'BG_DEFAULT',
            self::BG_BLACK => 'BG_BLACK',
            self::BG_RED => 'BG_RED',
            self::BG_GREEN => 'BG_GREEN',
            self::BG_YELLOW => 'BG_YELLOW',
            self::BG_BLUE => 'BG_BLUE',
            self::BG_MAGENTA => 'BG_MAGENTA',
            self::BG_CYAN => 'BG_CYAN',
            self::BG_LIGHT_GRAY => 'BG_LIGHT_GRAY',
            self::BG_DARK_GRAY => 'BG_DARK_GRAY',
            self::BG_LIGHT_RED => 'BG_LIGHT_RED',
            self::BG_LIGHT_GREEN => 'BG_LIGHT_GREEN',
            self::BG_LIGHT_YELLOW => 'BG_LIGHT_YELLOW',
            self::BG_LIGHT_BLUE => 'BG_LIGHT_BLUE',
            self::BG_LIGHT_MAGENTA => 'BG_LIGHT_MAGENTA',
            self::BG_LIGHT_CYAN => 'BG_LIGHT_CYAN',
            self::BG_WHITE => 'BG_WHITE',
        ];
}
