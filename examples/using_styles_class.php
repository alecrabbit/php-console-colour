<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/__helper_functions.php';
require_once __DIR__ . '/MyStylesClass.php';

use AlecRabbit\ConsoleColour\Styles;

try {
    $myStyles = new MyStylesClass();
    $styles = new Styles();
    echo $styles->red('This text is red.') . PHP_EOL;
    echo $styles->underlineBold('This text is underlined and bold.') . PHP_EOL;
    echo $myStyles->red('This text is red.') . PHP_EOL;
    echo $myStyles->lagoon('This is lagoon text.') . PHP_EOL;
    echo $myStyles->fire('This is fire text.') . PHP_EOL;
} catch (\Throwable $e) {
    showException($e);
}

