<?php declare(strict_types=1);

namespace AlecRabbit\Tests;

use AlecRabbit\ConsoleColour\Contracts\Styles as Style;
use AlecRabbit\ConsoleColour\Themes;

/**
 * @method fire(string $text)
 * @method new(string $text)
 * @method error(string $text) Redefining theme
 */
class ExtendedThemes extends Themes
{
    // These strings are used as methods names
    public const FIRE = 'fire';
    public const NEW = 'new';

    public const EXTENDED_STYLES = [
        // name => [styles],
        self::FIRE => [Style::LIGHT_RED, Style::BOLD, Style::BG_WHITE, Style::ITALIC],
        self::NEW => [Style::LIGHT_CYAN, Style::BG_BLACK, Style::UNDERLINE],
        self::ERROR => [Style::RED, Style::BG_WHITE, Style::UNDERLINE], // Overwriting existing
    ];

    /**
     * @return array
     */
    protected function prepareThemes(): array
    {
        return \array_merge(self::EXTENDED_STYLES, parent::prepareThemes());
    }
}
