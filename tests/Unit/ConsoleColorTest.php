<?php

namespace AlecRabbit\Tests\ConsoleColour;

use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\Tests\ConsoleColorOverride;
use PHPUnit\Framework\TestCase;

class ConsoleColorTest extends TestCase
{

    public const TEXT = 'Text to apply style to.';
    public const ESC_CHAR = ConsoleColor::ESC_CHAR;

    /** @var ConsoleColorOverride */
    private $cFF;
    /** @var ConsoleColorOverride */
    private $cTF;
    /** @var ConsoleColorOverride */
    private $cFT;
    /** @var ConsoleColorOverride */
    private $cTT;

    /** @test */
    public function getThemes(): void
    {
        $this->assertEquals([], $this->cFF->getThemes());
        $this->assertEquals([], $this->cTF->getThemes());
        $this->assertEquals([], $this->cFT->getThemes());
        $this->assertEquals([], $this->cTT->getThemes());
    }

    /** @test */
    public function isForcedAndSupported(): void
    {
        $this->assertFalse($this->cFF->isForced());
        $this->assertTrue($this->cTF->isForced());
        $this->assertFalse($this->cFT->isForced());
        $this->assertTrue($this->cTT->isForced());

        $this->assertFalse($this->cFF->isSupported());
        $this->assertTrue($this->cTF->isSupported());
        $this->assertFalse($this->cFT->isSupported());
        $this->assertTrue($this->cTT->isSupported());

        $this->assertFalse($this->cFF->are256ColorsSupported());
        $this->assertFalse($this->cTF->are256ColorsSupported());
        $this->assertFalse($this->cFT->are256ColorsSupported());
        $this->assertTrue($this->cTT->are256ColorsSupported());
    }

    /**
     * @test
     * @dataProvider multiDataProvider
     * @param array $expected
     * @param mixed $styles
     * @throws InvalidStyleException
     */
    public function multi(array $expected, $styles): void
    {
        [$cFF, $cFT, $cTF, $cTT] = $expected;
//        dump(Helper::stripEscape($this->cFF->apply($styles, self::TEXT)));
//        dump(Helper::stripEscape($this->cFT->apply($styles, self::TEXT)));
//        dump(Helper::stripEscape($this->cTF->apply($styles, self::TEXT)));
//        dump(Helper::stripEscape($this->cTT->apply($styles, self::TEXT)));
        $this->assertSame($cFF, $this->cFF->apply($styles, self::TEXT));
        $this->assertSame($cFT, $this->cFT->apply($styles, self::TEXT));
        $this->assertSame($cTF, $this->cTF->apply($styles, self::TEXT));
        $this->assertSame($cTT, $this->cTT->apply($styles, self::TEXT));
    }

    public function multiDataProvider(): array
    {
        return [
            // [[cFF, cFT, cTF, cTT], styles|[styles]]
            [
                [
                    self::TEXT,
                    self::TEXT,
                    self::TEXT,
                    self::TEXT,
                ],
                Styles::NONE,
            ],
            [
                [
                    self::TEXT,
                    self::TEXT,
                    $this->getColorStr([1]),
                    $this->getColorStr([1]),
                ],
                Styles::BOLD,
            ],
            [
                [
                    self::TEXT,
                    self::TEXT,
                    $this->getColorStr([2]),
                    $this->getColorStr([2]),
                ],
                Styles::DARK,
            ],
            [
                [
                    self::TEXT,
                    self::TEXT,
                    $this->getColorStr([2,1]),
                    $this->getColorStr([2,1]),
                ],
                [Styles::DARK,Styles::BOLD,]
            ],
            [
                [
                    self::TEXT,
                    self::TEXT,
                    self::TEXT,
                    $this->getColorStr([38, 5, 123]),
                ],
                'color_123',
            ],
            [
                [
                    self::TEXT,
                    self::TEXT,
                    $this->getColorStr([1]),
                    $this->getColorStr([38, 5, 123, 48, 5, 13, 1]),
                ],
                ['color_123', 'bg_color_13', 1],
            ],
            [
                [
                    self::TEXT,
                    self::TEXT,
                    $this->getColorStr([36, 1]),
                    $this->getColorStr([36, 48, 5, 13, 1]),
                ],
                [Styles::CYAN, 'bg_color_13', 1],
            ],
        ];
    }

    /**
     * @param array $styles
     * @return string
     */
    protected function getColorStr(array $styles): string
    {
        return self::ESC_CHAR . '[' . implode(';', $styles) . 'm' . self::TEXT . self::ESC_CHAR . '[0m';
    }

    protected function setUp(): void
    {
        $this->cFF = new ConsoleColorOverride(false, false);
        $this->cFT = new ConsoleColorOverride(false, true);
        $this->cTF = new ConsoleColorOverride(true, false);
        $this->cTT = new ConsoleColorOverride(true, true);
    }
}

