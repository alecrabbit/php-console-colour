<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Themes;

use AlecRabbit\ConsoleColour\Core\AbstractThemes;
use AlecRabbit\ConsoleColour\Themes\Contracts\DefaultThemes;
use AlecRabbit\ConsoleColour\Contracts\Styles as Style;

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
        self::DEBUG => Style::DARK,
        self::COMMENT => Style::YELLOW,
        self::ERROR => [Style::WHITE, Style::BOLD, Style::BG_RED],
        self::INFO => Style::GREEN,
    ];

    public const COLOR = [
        self::YELLOW => Style::YELLOW,
        self::GREEN => Style::GREEN,
        self::RED => Style::RED,
        self::CYAN => Style::CYAN,
        self::MAGENTA => Style::MAGENTA,
    ];
    public const THEMES = [
        self::ITALIC => Style::ITALIC,
        self::BOLD => Style::BOLD,
        self::DARK => Style::DARK,
        self::DARK_ITALIC => [Style::DARK, Style::ITALIC],
        self::WHITE => Style::WHITE,
        self::WHITE_BOLD => [Style::WHITE, Style::BOLD],
        self::UNDERLINED => [Style::UNDERLINE],
        self::UNDERLINED_BOLD => [Style::UNDERLINE, Style::BOLD],
        self::UNDERLINED_ITALIC => [Style::UNDERLINE, Style::ITALIC],
    ];

    /**
     * @return array
     */
    protected function prepareThemes(): array
    {
        return \array_merge(static::ACTIONS, static::COLOR, static::THEMES);
    }
}
