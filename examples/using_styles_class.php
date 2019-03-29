<?php

use AlecRabbit\ConsoleColour\Contracts\StylesInterface as Style;
use AlecRabbit\ConsoleColour\Styles;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/__helper_functions.php';

/**
 * @method fire(string $text)
 * @method lagoon(string $text)
 */
class MyTheme extends Styles
{
    // These strings are used as methods names
    public const FIRE = 'fire';
    public const LAGOON = 'lagoon';

    public const MY_THEMES = [
        // name => [styles],
        self::FIRE => [Styles::LIGHT_RED, Styles::BOLD, Styles::BG_WHITE, Styles::ITALIC],
        self::LAGOON => [Styles::LIGHT_BLUE, Styles::BG_BLACK, Styles::UNDERLINE],
    ];

    /**
     * @return array
     */
    protected function prepareThemes(): array
    {
        return \array_merge(self::MY_THEMES, parent::prepareThemes());
    }
}
try {
    $styles = new Styles();
    $extendedStyles = new ExtendedStyles();
    echo $styles->red('This text is red.') . PHP_EOL;
    echo $styles->underlineBold('This text is underlined and bold.') . PHP_EOL;
    echo $extendedStyles->red('This text is red.') . PHP_EOL;
    echo $extendedStyles->fire('This is fire text.') . PHP_EOL;
    echo $extendedStyles->laggon('This is lagoon text.') . PHP_EOL;
} catch (\Throwable $e) {
    showException($e);
}

