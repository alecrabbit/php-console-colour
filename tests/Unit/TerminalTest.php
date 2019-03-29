<?php declare(strict_types=1);

namespace AlecRabbit\tests\Unit;

use AlecRabbit\ConsoleColour\Terminal;
use PHPUnit\Framework\TestCase;

class TerminalTest extends TestCase
{
    /** @test */
    public function basic(): void
    {
        putenv('COLUMNS=100');
        putenv('LINES=50');
        $terminal = new Terminal();
        $this->assertSame(100, $terminal->width());
        $this->assertSame(50, $terminal->height());

        putenv('COLUMNS=120');
        putenv('LINES=60');
        $terminal = new Terminal();
        $this->assertNotEquals(120, $terminal->width());
        $this->assertNotEquals(60, $terminal->height());
        $this->assertSame(120, $terminal->width(true));
        $this->assertSame(60, $terminal->height(true));
    }

    /** @test */
    public function zeroValues(): void
    {
        putenv('COLUMNS=0');
        putenv('LINES=0');

        $terminal = new Terminal();
        $this->assertNotEquals(0, $terminal->width());
        $this->assertNotEquals(0, $terminal->height());
        $this->assertSame(0, $terminal->width(true));
        $this->assertSame(0, $terminal->height(true));
    }

    /** @test */
    public function colorSupport(): void
    {
        $terminal = new Terminal();

        $this->assertTrue($terminal->supportsColor());
        if ($this->checkTermVarFor256ColorSupport('TERM') || $this->checkTermVarFor256ColorSupport('DOCKER_TERM')) {
            $this->assertTrue($terminal->supports256Color());
        } else {
            $this->assertFalse($terminal->supports256Color());
        }
    }

    /**
     * @param string $varName
     * @return bool
     */
    protected function checkTermVarFor256ColorSupport(string $varName): bool
    {
        if ($t = getenv($varName)) {
            return
                false !== strpos($t, '256color');
        }
        return false;
    }

}