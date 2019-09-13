<?php declare(strict_types=1);

if (!\function_exists('boolToString')) {
    function boolToString(?bool $value): string
    {
        if (null === $value) {
            return 'null';
        }
        return $value ? 'true' : 'false';
    }
}