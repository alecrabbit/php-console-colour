<?php

use AlecRabbit\ConsoleColour\Theme;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/functions.php';

try {
    $theme = new Theme();
    echo $theme->red('This text is red.') . PHP_EOL;
    echo $theme->underlineBold('This text is underlined and bold.') . PHP_EOL;
} catch (\Throwable $e) {
    showException($e);
}

