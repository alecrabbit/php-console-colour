<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Themes;

use AlecRabbit\ConsoleColour\Contracts\BG;
use AlecRabbit\ConsoleColour\Contracts\Color;
use AlecRabbit\ConsoleColour\Contracts\Effect;
use AlecRabbit\ConsoleColour\Core\AbstractThemes;
use AlecRabbit\ConsoleColour\Themes\Contracts\DefaultThemes;

/**
 * @method comment(string $text)
 * @method error(string $text)
 * @method info(string $text)
 *
 * @method yellow(string $text)
 * @method red(string $text)
 * @method green(string $text)
 * @method cyan(string $text)
 * @method magenta(string $text)
 *
 * @method italic(string $text)
 * @method bold(string $text)
 * @method dark(string $text)
 * @method darkItalic(string $text)
 * @method white(string $text)
 * @method whiteBold(string $text)
 * @method underlined(string $text)
 * @method underlinedBold(string $text)
 * @method underlinedItalic(string $text)
 */
class Themes extends AbstractThemes implements DefaultThemes
{
    public const ACTIONS = [
        self::DEBUG => Effect::DARK,
        self::COMMENT => Color::YELLOW,
        self::ERROR => [Color::WHITE, Effect::BOLD, BG::RED],
        self::INFO => Color::GREEN,
    ];

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

    public const EFFECTS = [
        self::ITALIC => Effect::ITALIC,
        self::BOLD => Effect::BOLD,
        self::DARK => Effect::DARK,
        self::UNDERLINED => [Effect::UNDERLINE],
        self::CROSSED => [Effect::CROSSED_OUT],
    ];

    public const THEMES = [
        self::DARK_ITALIC => [Effect::DARK, Effect::ITALIC],
        self::WHITE_BOLD => [Color::WHITE, Effect::BOLD],
        self::UNDERLINED_BOLD => [Effect::UNDERLINE, Effect::BOLD],
        self::UNDERLINED_ITALIC => [Effect::UNDERLINE, Effect::ITALIC],
    ];

    /**
     * @return array
     */
    protected function prepareThemes(): array
    {
        return \array_merge(static::ACTIONS, static::COLORS,static::EFFECTS, static::THEMES);
    }
}
