<?php declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/__helper_functions.php';

use AlecRabbit\ConsoleColour\Contracts\BG;
use AlecRabbit\ConsoleColour\Contracts\Color;
use AlecRabbit\ConsoleColour\Contracts\Effect;
use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Themes\Themes;

/**
 * @method fire(string $text)
 * @method lagoon(string $text)
 * @method blink(string $text)
 * @method alert(string $text)
 */
class MyThemes extends Themes
{
    // These strings are used as methods names
    public const FIRE = 'fire';
    public const LAGOON = 'lagoon';
    public const BLINK = 'blink';
    public const ALERT = 'alert';

    public const MY_STYLES = [
        // name => [styles],
        self::FIRE => [Color::LIGHT_RED, Effect::BOLD, BG::LIGHT_YELLOW, Effect::ITALIC],
        self::LAGOON => [Color::BLACK, BG::LIGHT_BLUE, Effect::UNDERLINE],
        self::BLINK => [Effect::BLINK, Color::LIGHT_CYAN],
        // You can use interface `Styles` to define your theme
        self::ALERT => [Styles::BLINK, Styles::WHITE, Styles::BG_LIGHT_RED],
    ];

    /**
     * @return array
     */
    protected function prepareThemes(): array
    {
        return \array_merge(self::MY_STYLES, parent::prepareThemes());
    }
}

$base = new Themes();
$my = new MyThemes();
echoText($base->red('This text is red.'));
echoText($base->comment('This is comment.'));
echoText($base->underlinedBold('This text is underlined and bold.'));
echoText($my->green('This text is green.')); // Method defined in Themes class
echoText($my->blink('This text is light cyan and blinking.'));
echoText($my->lagoon('This is "lagoon" text.'));
echoText($my->fire('This is "fire" text.'));
echoText($my->error('This is "error" text.'));
echoText($my->alert('This is "alert" text.'));
