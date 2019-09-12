<?php declare(strict_types=1);

namespace AlecRabbit\Tests\ConsoleColour;

use AlecRabbit\Cli\Tools\Core\Terminal;
use AlecRabbit\ConsoleColour\ConsoleColor;
use PHPUnit\Framework\TestCase;
use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\NO_COLOR_TERMINAL;
use const AlecRabbit\TRUECOLOR_TERMINAL;

class ConsoleColorTest extends TestCase
{
    /**
     * @test
     * @dataProvider instanceDataProvider
     * @param null|int $colorLevel
     * @param bool $supported
     */
    public function instance(?int $colorLevel, bool $supported): void
    {
        $stream = STDOUT;
        $colorSupport = Terminal::colorSupport($stream);
        $c = new ConsoleColor($stream, $colorLevel);
        $this->assertEquals($supported, $c->isSupported());
        $this->assertSame($colorLevel, $c->getColorLevel());
        if ($colorSupport >= $colorLevel) {
            $this->assertFalse($c->isForced());
        } else {
            $this->assertTrue($c->isForced());
        }
    }

    public function instanceDataProvider(): array
    {
        return [
            [NO_COLOR_TERMINAL, false],
            [COLOR_TERMINAL, true],
            [COLOR256_TERMINAL, true],
            [TRUECOLOR_TERMINAL, true],
        ];
    }
}