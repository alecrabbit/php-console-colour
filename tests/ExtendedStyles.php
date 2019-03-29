<?php declare(strict_types=1);

namespace AlecRabbit\Tests;

use AlecRabbit\ConsoleColour\Contracts\StylesInterface as Style;
use AlecRabbit\ConsoleColour\Styles;

/**
 * @method fire(string $text)
 * @method new(string $text)
 */
class ExtendedStyles extends Styles
{
    // These strings are used as methods names
    public const FIRE = 'fire';
    public const NEW = 'new';

    public const EXTENDED_STYLES = [
        // name => [styles],
        self::FIRE => [Style::LIGHT_RED, Style::BOLD, Style::BG_WHITE, Style::ITALIC],
        self::NEW => [Style::LIGHT_CYAN, Style::BG_BLACK, Style::UNDERLINE],
    ];

    /**
     * @return array
     */
    protected function prepareThemes(): array
    {
        return \array_merge(self::EXTENDED_STYLES, parent::prepareThemes());
    }
}
