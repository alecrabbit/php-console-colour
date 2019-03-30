<?php declare(strict_types=1);

/**
 * @param $e
 */
function showException(\Throwable $e): void
{
    echo '[' . get_class($e) . '] ' . $e->getMessage() . PHP_EOL;
}

/**
 * @param string $text
 * @param int $eolNumber
 */
function echoText(string $text, int $eolNumber = 2): void
{
    echo $text . str_repeat(PHP_EOL, $eolNumber);
}
