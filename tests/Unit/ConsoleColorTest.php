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
    public const STYLES_COUNT = 45;

    /**
     * @test
     * @dataProvider instanceDataProvider
     * @param resource $stream
     * @param null|int $colorLevel
     * @param bool $applicable
     */
    public function instance($stream, ?int $colorLevel, bool $applicable): void
    {
        $colorSupport = Terminal::colorSupport($stream);
        $c = new ConsoleColor($stream, $colorLevel);
        $this->assertEquals($applicable, $c->isApplicable());
        $this->assertSame($colorLevel, $c->getColorLevel());
        if (NO_COLOR_TERMINAL === $colorLevel) {
            $this->assertFalse($c->isForced());
            $this->assertFalse($c->isSupported());
        } elseif ($colorSupport >= $colorLevel) {
            $this->assertFalse($c->isForced());
            $this->assertTrue($c->isSupported());
        } else {
            $this->assertTrue($c->isForced());
            $this->assertFalse($c->isSupported());
        }
        $this->assertSame([], $c->getThemes());
        $this->helperCheckPossibleStyles($c->getPossibleStyles());
    }

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

    public function instanceDataProvider(): array
    {
        return [
            [STDOUT, NO_COLOR_TERMINAL, false],
            [STDOUT, COLOR_TERMINAL, true],
            [STDOUT, COLOR256_TERMINAL, true],
            [STDOUT, TRUECOLOR_TERMINAL, true],
        ];
    }

    /**
     * @param $possibleStyles
     */
    protected function helperCheckPossibleStyles($possibleStyles): void
    {
        $this->assertIsArray($possibleStyles);
        $this->assertNotEmpty($possibleStyles);
        $this->assertCount(self::STYLES_COUNT, $possibleStyles);
    }


}