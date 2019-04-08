<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour;

use AlecRabbit\ConsoleColour\Contracts\Color;
use AlecRabbit\ConsoleColour\Contracts\Effect;
use AlecRabbit\ConsoleColour\Core\AbstractThemes;
use AlecRabbit\ConsoleColour\Themes\Contracts\ActionsThemes;
use AlecRabbit\ConsoleColour\Themes\Contracts\ColorsThemes;
use AlecRabbit\ConsoleColour\Themes\Contracts\EffectsThemes;

/**
 * @method debug(string $text)
 * @method comment(string $text)
 * @method info(string $text)
 * @method error(string $text)
 * @method warning(string $text)
 * @method yellow(string $text)
 * @method green(string $text)
 * @method red(string $text)
 * @method cyan(string $text)
 * @method magenta(string $text)
 * @method black(string $text)
 * @method blue(string $text)
 * @method lightGray(string $text)
 * @method darkGray(string $text)
 * @method lightRed(string $text)
 * @method lightGreen(string $text)
 * @method lightYellow(string $text)
 * @method lightBlue(string $text)
 * @method lightMagenta(string $text)
 * @method lightCyan(string $text)
 * @method white(string $text)
 * @method italic(string $text)
 * @method bold(string $text)
 * @method dark(string $text)
 * @method crossed(string $text)
 * @method darkItalic(string $text)
 * @method whiteBold(string $text)
 * @method underlined(string $text)
 * @method underlinedBold(string $text)
 * @method underlinedItalic(string $text)
 */
class Themes extends AbstractThemes implements EffectsThemes, ActionsThemes, ColorsThemes
{
    public const DARK_ITALIC = 'darkItalic';
    public const WHITE_BOLD = 'whiteBold';
    public const UNDERLINED_BOLD = 'underlinedBold';
    public const UNDERLINED_ITALIC = 'underlinedItalic';

    public const THEMES = [
        self::DARK_ITALIC => [Effect::DARK, Effect::ITALIC],
        self::WHITE_BOLD => [Color::WHITE, Effect::BOLD],
        self::UNDERLINED_BOLD => [Effect::UNDERLINE, Effect::BOLD],
        self::UNDERLINED_ITALIC => [Effect::UNDERLINE, Effect::ITALIC],
    ];

    public function none(string $text):string
    {
        return $text;
    }

    /**
     * @return array
     */
    protected function prepareThemes(): array
    {
        return \array_merge(static::ACTIONS, static::COLORS, static::EFFECTS, static::THEMES);
    }
}
