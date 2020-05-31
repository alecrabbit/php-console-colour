<?php

declare(strict_types=1);


use AlecRabbit\Console\Color\ClosestColor256;
use AlecRabbit\Console\Color\Converter;
use AlecRabbit\Tests\Helper;

require_once __DIR__ . '/bootstrap.php';

for($i=0;$i<255;$i++ ){

    $text = sprintf(
        "\x1b[%sm%s\x1b[0m",
        $i,
        'TEXT'
    );
    echo $text . PHP_EOL;
}
    echo PHP_EOL;
