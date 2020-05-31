<?php

declare(strict_types=1);

use AlecRabbit\Console\Color\Converter;

require_once __DIR__ . '/bootstrap.php';

$data = [
    '#ff3',
    'ff3a',
    dechex((int)(string)0x1123),
    0x1123,
    4387,
//    new \stdClass(),
    'ff30',
    'fffffffff',
    '#ff30',
];
foreach ($data as $hex) {
    dump(
        $hex,
        Converter::normalizeHex($hex),
        sprintf('[R:%s, G:%s, B:%s, A:%s]', ...Converter::hex2rgba($hex))
    );
}
