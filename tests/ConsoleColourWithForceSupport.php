<?php declare(strict_types=1);

namespace AlecRabbit\Tests;

use AlecRabbit\ConsoleColour\ConsoleColour;

class ConsoleColourWithForceSupport extends ConsoleColour
{
    private $isSupportedForce = true;

    private $are256ColorsSupportedForce = true;

    public function setIsSupported($isSupported): void
    {
        $this->isSupportedForce = $isSupported;
    }

    public function isSupported(): bool
    {
        return $this->isSupportedForce;
    }

    public function setAre256ColorsSupported($are256ColorsSupported): void
    {
        $this->are256ColorsSupportedForce = $are256ColorsSupported;
    }

    public function are256ColorsSupported(): bool
    {
        return $this->are256ColorsSupportedForce;
    }
}
