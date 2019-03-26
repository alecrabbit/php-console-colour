<?php declare(strict_types=1);


namespace AlecRabbit\ConsoleColour\Contracts;

interface StylesInterface
{
    public const FOREGROUND = 38;

    public const BACKGROUND = 48;

    public const RESET_STYLE = 0;

    public const COLOR256_REGEXP = '~^(bg_)?color_(\d{1,3})$~';

    public const NONE = 'none';
    public const BOLD = 'bold';
    public const DARK = 'dark';
    public const ITALIC = 'italic';
    public const UNDERLINE = 'underline';
    public const BLINK = 'blink';
    public const REVERSE = 'reverse';
    public const CONCEALED = 'concealed';

    public const DEFAULT = 'default';
    public const BLACK = 'black';
    public const RED = 'red';
    public const GREEN = 'green';
    public const YELLOW = 'yellow';
    public const BLUE = 'blue';
    public const MAGENTA = 'magenta';
    public const CYAN = 'cyan';
    public const LIGHT_GRAY = 'light_gray';

    public const DARK_GRAY = 'dark_gray';
    public const LIGHT_RED = 'light_red';
    public const LIGHT_GREEN = 'light_green';
    public const LIGHT_YELLOW = 'light_yellow';
    public const LIGHT_BLUE = 'light_blue';
    public const LIGHT_MAGENTA = 'light_magenta';
    public const LIGHT_CYAN = 'light_cyan';
    public const WHITE = 'white';

    public const BG_DEFAULT = 'bg_default';
    public const BG_BLACK = 'bg_black';
    public const BG_RED = 'bg_red';
    public const BG_GREEN = 'bg_green';
    public const BG_YELLOW = 'bg_yellow';
    public const BG_BLUE = 'bg_blue';
    public const BG_MAGENTA = 'bg_magenta';
    public const BG_CYAN = 'bg_cyan';
    public const BG_LIGHT_GRAY = 'bg_light_gray';

    public const BG_DARK_GRAY = 'bg_dark_gray';
    public const BG_LIGHT_RED = 'bg_light_red';
    public const BG_LIGHT_GREEN = 'bg_light_green';
    public const BG_LIGHT_YELLOW = 'bg_light_yellow';
    public const BG_LIGHT_BLUE = 'bg_light_blue';
    public const BG_LIGHT_MAGENTA = 'bg_light_magenta';
    public const BG_LIGHT_CYAN = 'bg_light_cyan';
    public const BG_WHITE = 'bg_white';

    public const STYLES =
        [
            self::NONE => null,
            self::BOLD => '1',
            self::DARK => '2',
            self::ITALIC => '3',
            self::UNDERLINE => '4',
            self::BLINK => '5',
            self::REVERSE => '7',
            self::CONCEALED => '8',

            self::DEFAULT => '39',
            self::BLACK => '30',
            self::RED => '31',
            self::GREEN => '32',
            self::YELLOW => '33',
            self::BLUE => '34',
            self::MAGENTA => '35',
            self::CYAN => '36',
            self::LIGHT_GRAY => '37',

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
}