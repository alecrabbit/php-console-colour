<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Color\Core;

class MultiColor
{
    private $color;

    public function __construct($color)
    {
        $this->assertColor($color);
        $this->color = $color;
    }

    /**
     * @param mixed $color
     */
    private function assertColor($color): void
    {
        // TODO
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }
}