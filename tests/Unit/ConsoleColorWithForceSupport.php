<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Unit;

use JakubOnderka\PhpConsoleColor\ConsoleColor;

class ConsoleColorWithForceSupport extends ConsoleColor
{
    private $isSupportedForce = true;

    private $are256ColorsSupportedForce = true;

    public function setIsSupported($isSupported)
    {
        $this->isSupportedForce = $isSupported;
    }

    public function isSupported()
    {
        return $this->isSupportedForce;
    }

    public function setAre256ColorsSupported($are256ColorsSupported)
    {
        $this->are256ColorsSupportedForce = $are256ColorsSupported;
    }

    public function are256ColorsSupported()
    {
        return $this->are256ColorsSupportedForce;
    }
}
