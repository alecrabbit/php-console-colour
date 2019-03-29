<?php declare(strict_types=1);

/**
 * @param $e
 */
function showException(\Throwable $e): void
{
    echo '[' . get_class($e) . '] ' . $e->getMessage() . PHP_EOL;
}
