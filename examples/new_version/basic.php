<?php

declare(strict_types=1);

use AlecRabbit\Console\Color\Color;
use AlecRabbit\Console\Style\Style;
use AlecRabbit\Tests\Helper;

require_once __DIR__ . '/../../vendor/autoload.php';

$color = new Color();

$style = new Style(234, null, [3]);

$result = $color->apply($style, 'TeXt');

dump(Helper::stripEscape($result));
echo $result;

echo PHP_EOL;
echo PHP_EOL;