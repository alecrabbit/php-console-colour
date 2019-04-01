<?php declare(strict_types=1);

namespace AlecRabbit\Tests;

use AlecRabbit\ConsoleColour\ConsoleColor;

class ConsoleColorOverride extends ConsoleColor
{
    protected function setColorSupport(bool $force, bool $force256Colors): void
    {
        $this->supported = $force;
        $this->are256ColorsSupported = $this->supported && $force256Colors;
    }
}
