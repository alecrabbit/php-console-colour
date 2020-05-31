<?php

declare(strict_types=1);

use AlecRabbit\Console\Color\Color;
use AlecRabbit\Console\Style\Style;
use AlecRabbit\ConsoleColour\Contracts\Effect;
use AlecRabbit\Tests\Helper;

require_once __DIR__ . '/bootstrap.php';

$color = new Color();

$effects = [
    Effect::ITALIC,
    Effect::BLINK,
    Effect::CROSSED_OUT
];
$style = new Style(31, null, $effects);

$result = $color->apply($style, 'TeXt');

dump(Helper::replaceEscape($result));
echo $result;

echo PHP_EOL;
echo PHP_EOL;