<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/__helper_functions.php';

use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Contracts\Effect;
use AlecRabbit\ConsoleColour\Contracts\Styles;

const TEXT = '  *** Sample text ***  ';
const UNSUPPORTED = [Styles::BLINK_FAST, Styles::DOUBLE_UNDERLINE, Styles::CROSSED_OUT];

try {
    perform(new ConsoleColor());
} catch (\Throwable $e) {
    showException($e);
}

/**
 * @param ConsoleColor $colour
 * @throws Throwable
 */
function perform(ConsoleColor $colour): void
{
    echo '[' . get_class($colour) . ']' . PHP_EOL;
    echo 'Colors are supported: ' . ($colour->isSupported() ? 'Yes' : 'No') . PHP_EOL;
    if ($colour->isSupported()) {
        echo 'Regular colors...' . PHP_EOL;

        foreach ($colour->getPossibleStyles() as $style) {
            $name = Styles::NAMES[$style];
            if (\in_array($style, UNSUPPORTED, true)) {
                $name .=  $colour->apply(Effect::DARK, ' (Not widely supported)')  ;
            }
            echo
                ' ' . $colour->apply($style, TEXT) . ' ' . $name . PHP_EOL;
        }

        echo PHP_EOL;
        echo '256 colors are supported: ' . ($colour->are256ColorsSupported() ? 'Yes' : 'No') . PHP_EOL;
        if ($colour->are256ColorsSupported()) {
            echo 'Foreground colors:' . PHP_EOL;
            display($colour);
            echo PHP_EOL . 'Background colors:' . PHP_EOL;
            display($colour, 'bg_');
            echo PHP_EOL;
        }
    }
}

/**
 * @param ConsoleColor $colour
 * @param string $stylePrefix
 * @return int
 * @throws Throwable
 */
function display(ConsoleColor $colour, string $stylePrefix = ''): int
{
    for ($i = 0; $i <= 255; $i++) {
        echo $colour->apply($stylePrefix . 'color_' . $i, str_pad($i, 6, ' ', STR_PAD_BOTH));

        if (($i + 1) % 16 === 0) {
            echo PHP_EOL;
        }
    }
    return $i;
}


