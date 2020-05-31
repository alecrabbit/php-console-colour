<?php

namespace AlecRabbit\Console\Color;

interface ClosestColor256Interface
{
    public const WRONG_COLOR_VALUE_MESSAGE = 'Wrong color value [%s:%s]';
    public const COLORS = ['R', 'G', 'B'];

    /**
     * @param int|string $hex
     * @return int
     */
    public function hex(string $hex): int;

    /**
     * @param int $r
     * @param int $g
     * @param int $b
     * @param int|null $a   ignored
     * @return int
     */
    public function rgba(int $r, int $g, int $b, ?int $a = null): int;
}