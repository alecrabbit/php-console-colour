<?php declare(strict_types=1);

use AlecRabbit\ConsoleColour\Contracts\StylesInterface as Style;
use AlecRabbit\ConsoleColour\Styles;

/**
 * @method fire(string $text)
 * @method lagoon(string $text)
 */
class MyStylesClass extends Styles
{
    // These strings are used as methods names
    public const FIRE = 'fire';
    public const LAGOON = 'lagoon';

    public const EXTENDED_STYLES = [
        // name => [styles],
        self::FIRE => [Style::LIGHT_RED, Style::BOLD, Style::BG_WHITE, Style::ITALIC],
        self::LAGOON => [Style::LIGHT_BLUE, Style::BG_BLACK, Style::UNDERLINE],
    ];

    /**
     * @return array
     */
    protected function prepareThemes(): array
    {
        return \array_merge(self::EXTENDED_STYLES, parent::prepareThemes());
    }
}
