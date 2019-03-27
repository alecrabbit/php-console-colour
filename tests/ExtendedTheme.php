<?php declare(strict_types=1);

namespace AlecRabbit\Tests;

use AlecRabbit\ConsoleColour\Contracts\StylesInterface as Styles;
use AlecRabbit\ConsoleColour\Theme;

/**
 * @method fire(string $text)
 * @method new(string $text)
 */
class ExtendedTheme extends Theme
{
    // These strings are used as methods names
    public const FIRE = 'fire';
    public const NEW = 'new';

    public const EXTENDED_THEMES = [
        // name => [styles],
        self::FIRE => [Styles::LIGHT_RED, Styles::BOLD, Styles::BG_WHITE, Styles::ITALIC],
        self::NEW => [Styles::LIGHT_CYAN, Styles::BG_BLACK, Styles::UNDERLINE],
    ];

    /**
     * @return array
     */
    protected function prepareThemes(): array
    {
        return \array_merge(self::EXTENDED_THEMES, parent::prepareThemes());
    }
}
