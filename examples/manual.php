<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/__helper_functions.php';

use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Contracts\Effect;
use AlecRabbit\ConsoleColour\Contracts\Styles;

const TEXT = '  *** Sample text ***  ';
$colour = new ConsoleColor();
echo $colour->apply(['color_166','bg_color_123', Effect::BOLD, Effect::UNDERLINE, Effect::BLINK], str_pad(TEXT, 6, ' ', STR_PAD_BOTH));

