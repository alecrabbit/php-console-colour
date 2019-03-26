<?php declare(strict_types=1);

namespace AlecRabbit\tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Terminal;

class TerminalTest extends TestCase
{
    /** @test */
    public function basic(): void
    {
        putenv('COLUMNS=100');
        putenv('LINES=50');
        $terminal = new Terminal();
        $this->assertSame(100, $terminal->getWidth());
        $this->assertSame(50, $terminal->getHeight());

        putenv('COLUMNS=120');
        putenv('LINES=60');
        $terminal = new Terminal();
        $this->assertSame(120, $terminal->getWidth());
        $this->assertSame(60, $terminal->getHeight());
    }

    /** @test */
    public function zeroValues(): void
    {
        putenv('COLUMNS=0');
        putenv('LINES=0');

        $terminal = new Terminal();

        $this->assertSame(0, $terminal->getWidth());
        $this->assertSame(0, $terminal->getHeight());
    }

    /** @test */
    public function colorSupport(): void
    {
        $terminal = new Terminal();

        $this->assertTrue($terminal->supportsColor());
        $this->assertFalse($terminal->supports256Color());
    }
}