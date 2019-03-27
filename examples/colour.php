<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/functions.php';

use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\ConsoleColour;

const TEXT = '  *** Sample text ***  ';

try {
    perform(new ConsoleColor());
    perform(new ConsoleColour());
} catch (\Throwable $e) {
    showException($e);
}

/**
 * @param ConsoleColor $consoleColor
 * @throws Throwable
 */
function perform(ConsoleColor $consoleColor): void
{
    echo '[' . get_class($consoleColor) . ']' . PHP_EOL;
    echo 'Colors are supported: ' . ($consoleColor->isSupported() ? 'Yes' : 'No') . PHP_EOL;
    echo '256 colors are supported: ' . ($consoleColor->are256ColorsSupported() ? 'Yes' : 'No') . PHP_EOL . PHP_EOL;

    if ($consoleColor->isSupported()) {
        echo 'Regular colors...' . PHP_EOL;

        foreach ($consoleColor->getPossibleStyles() as $style) {
            echo
                $consoleColor->apply($style, TEXT) . ' ' . $style . PHP_EOL;
        }
    }

    echo PHP_EOL;

    if ($consoleColor->are256ColorsSupported()) {
        echo '256 colors...' . PHP_EOL;
        echo 'Foreground colors:' . PHP_EOL;
        display($consoleColor);
        echo PHP_EOL . 'Background colors:' . PHP_EOL;
        display($consoleColor, 'bg_');
        echo PHP_EOL;
    }

}

/**
 * @param ConsoleColor $consoleColor
 * @param string $stylePrefix
 * @return int
 * @throws Throwable
 */
function display(ConsoleColor $consoleColor, string $stylePrefix = ''): int
{
    for ($i = 0; $i <= 255; $i++) {
        echo $consoleColor->apply($stylePrefix . 'color_' . $i, str_pad($i, 6, ' ', STR_PAD_BOTH));

        if (($i + 1) % 16 === 0) {
            echo PHP_EOL;
        }
    }
    return $i;
}


