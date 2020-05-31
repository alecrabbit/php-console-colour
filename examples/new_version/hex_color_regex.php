<?php

declare(strict_types=1);

const REGEXP = "/^#((?:[\da-f]{3}){1,2}|(?:[\da-f]{4}){1,2})$/i";

require_once __DIR__ . '/bootstrap.php';

$c = new \AlecRabbit\Console\Color\ClosestColor256();

$hex = '#f3e11';

dump((bool)preg_match(REGEXP, $hex));
