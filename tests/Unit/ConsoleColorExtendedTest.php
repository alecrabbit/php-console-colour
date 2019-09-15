<?php declare(strict_types=1);

namespace AlecRabbit\Tests\ConsoleColour;

use AlecRabbit\Cli\Tools\Core\Terminal;
use AlecRabbit\ConsoleColour\ConsoleColor;
use PHPUnit\Framework\TestCase;
use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\NO_COLOR_TERMINAL;
use const AlecRabbit\TRUECOLOR_TERMINAL;

class ConsoleColorExtendedTest extends TestCase
{
    /** @var ConsoleColor */
    private $cFF;
    /** @var ConsoleColor */
    private $cTF;
    /** @var ConsoleColor */
    private $cFT;
    /** @var ConsoleColor */
    private $cTT;

    /** @test */
    public function instanceWithDefaults(): void
    {
        $colorSupport = Terminal::colorSupport();
        $c = new ConsoleColor();
        $this->assertIsInt($c->getColorLevel());
        if ($colorSupport > NO_COLOR_TERMINAL) {
            $this->assertTrue($c->isApplicable());
            $this->assertTrue($c->isSupported());
            $this->assertFalse($c->isForced());
        }
    }

    protected function setUp(): void
    {
        $this->cFF = new ConsoleColor(STDOUT, null);
        $this->cFT = new ConsoleColor(STDOUT, null);
        $this->cTF = new ConsoleColor(STDOUT, null);
        $this->cTT = new ConsoleColor(STDOUT, null);
    }
}