<?php

declare(strict_types=1);


use AlecRabbit\Console\Color\ClosestColor256;
use AlecRabbit\Console\Color\Converter;
use AlecRabbit\Tests\Helper;

require_once __DIR__ . '/bootstrap.php';

const TEXT = 'SoMe TeXt';
const PAD_LENGTH = 52;
const PAD_STR = ' ';

$c = new ClosestColor256();

//$hexs = [
//    '#ffffffaa',
//    'fafafa',
//    'e7e7e7',
//    '8700d5',
//    '870',
//     0x870,
//    'ad7',
//    'f4f',
//    'd56323',
//    'd52363',
//    'fff',
//    '82376455',
//    '887700',
//];
$hexs = [
    '000000',
    '800000',
    '008000',
    '808000',
    '000080',
    '800080',
    '008080',
    'c0c0c0',
    '808080',
    'ff0000',
    '00ff00',
    'ffff00',
    '0000ff',
    'ff00ff',
    '00ffff',
    'ffffff',
];

foreach ($hexs as $hex) {
    $color256Number = $c->hex($hex);
    $color256Text = sprintf(
        "\x1b[38;5;%sm%s\x1b[0m",
        $color256Number,
        TEXT
    );
    [$r, $g, $b, $a] = Converter::hex2rgba($hex);
    $truecolorText = sprintf(
        "\x1b[38;2;%sm%s\x1b[0m",
        implode(';', [$r, $g, $b]),
        TEXT
    );
    echo
        sprintf(
            'Hex: %s Normalized: %s',
            str_pad('(' . \gettype($hex) . ')' . $hex, PAD_LENGTH, PAD_STR),
            Converter::normalizeHex($hex)
        ) . PHP_EOL;
    echo
        sprintf(
            '%s %s %s',
            str_pad(Helper::replaceEscape($truecolorText), PAD_LENGTH, PAD_STR),
            str_pad('', 3, PAD_STR),
            str_pad(Helper::replaceEscape($color256Text), PAD_LENGTH, PAD_STR),
        ) . PHP_EOL;
    echo
        sprintf(
            '%s                                 Closest: [%s] %s',
            $truecolorText,
            str_pad((string)$color256Number, 3, PAD_STR, STR_PAD_LEFT),
            $color256Text
        ) . PHP_EOL;
    echo PHP_EOL;
}