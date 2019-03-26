<?php

use AlecRabbit\ConsoleColour\ConsoleColour;
use AlecRabbit\ConsoleColour\Exception\ColorException;

const TEXT = '  *** Sample text ***  ';
require_once __DIR__ . '/../vendor/autoload.php';

$consoleColor = new ConsoleColour();

if ($consoleColor->isSupported()) {
    echo 'Regular colors:' . PHP_EOL;

    foreach ($consoleColor->getPossibleStyles() as $style) {
        echo
            $consoleColor->apply($style, TEXT) . ' ' . $style . PHP_EOL;
    }
}

echo PHP_EOL;

/**
 * @param ConsoleColour $consoleColor
 * @param string $stylePrefix
 * @return int
 * @throws Throwable
 * @throws ColorException
 */
function display(ConsoleColour $consoleColor, string $stylePrefix = ''): int
{
    for ($i = 0; $i <= 255; $i++) {
        echo $consoleColor->apply($stylePrefix . 'color_' . $i, str_pad($i, 6, ' ', STR_PAD_BOTH));

        if (($i + 1) % 16 === 0) {
            echo PHP_EOL;
        }
    }
    return $i;
}

/**
 * @param $e
 */
function showException($e): void
{
    echo '[' . get_class($e) . ']' . $e->getMessage();
}

if ($consoleColor->are256ColorsSupported()) {
    echo '256 colors:' . PHP_EOL;
    try {
        echo 'Foreground colors:' . PHP_EOL;
        display($consoleColor);
        echo PHP_EOL . 'Background colors:' . PHP_EOL;
        display($consoleColor, 'bg_');
        echo PHP_EOL;
    } catch (ColorException $e) {
        showException($e);
    } catch (Throwable $e) {
        showException($e);
    }
}

echo 'Colors are supported: ' . ($consoleColor->isSupported() ? 'Yes' : 'No') . PHP_EOL;
echo '256 colors are supported: ' . ($consoleColor->are256ColorsSupported() ? 'Yes' : 'No') . PHP_EOL . PHP_EOL;

