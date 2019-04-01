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
    public const STYLES_COUNT = 45;
    public const COLOR_2156 = 'color_2156';
    public const INVALID = 'invalid';

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
                    $this->helperGetColorStr([1]),
                    $this->helperGetColorStr([1]),
                ],
                Styles::BOLD,
            ],
            [
                [
                    self::TEXT,
                    self::TEXT,
                    $this->helperGetColorStr([2]),
                    $this->helperGetColorStr([2]),
                ],
                Styles::DARK,
            ],
            [
                [
                    self::TEXT,
                    self::TEXT,
                    $this->helperGetColorStr([2, 1]),
                    $this->helperGetColorStr([2, 1]),
                ],
                [Styles::DARK, Styles::BOLD,],
            ],
            [
                [
                    self::TEXT,
                    self::TEXT,
                    self::TEXT,
                    $this->helperGetColorStr([38, 5, 123]),
                ],
                'color_123',
            ],
            [
                [
                    self::TEXT,
                    self::TEXT,
                    $this->helperGetColorStr([1]),
                    $this->helperGetColorStr([38, 5, 123, 48, 5, 13, 1]),
                ],
                ['color_123', 'bg_color_13', 1],
            ],
            [
                [
                    self::TEXT,
                    self::TEXT,
                    $this->helperGetColorStr([36, 1]),
                    $this->helperGetColorStr([36, 48, 5, 13, 1]),
                ],
                [Styles::CYAN, 'bg_color_13', 1],
            ],
        ];
    }

    /**
     * @param array $styles
     * @return string
     */
    protected function helperGetColorStr(array $styles): string
    {
        return self::ESC_CHAR . '[' . implode(';', $styles) . 'm' . self::TEXT . self::ESC_CHAR . '[0m';
    }

    /** @test */
    public function GetPossibleStyles(): void
    {
        $this->helperCheckPossibleStyles($this->cFF->getPossibleStyles());
        $this->helperCheckPossibleStyles($this->cFT->getPossibleStyles());
        $this->helperCheckPossibleStyles($this->cTF->getPossibleStyles());
        $this->helperCheckPossibleStyles($this->cTT->getPossibleStyles());
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

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ThemeInvalidStyleCFF(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->cFF->addTheme(self::INVALID, [self::INVALID]);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ThemeInvalidStyleCFT(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->cFT->addTheme(self::INVALID, [self::INVALID]);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ThemeInvalidStyleCTF(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->cTF->addTheme(self::INVALID, [self::INVALID]);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ThemeInvalidStyleCTT(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->cTT->addTheme(self::INVALID, [self::INVALID]);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidArgumentCFF(): void
    {
        $this->assertSame(
            self::TEXT,
            $this->cFF->apply(new \stdClass(), self::TEXT)
        );
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidArgumentCFT(): void
    {
        $this->assertSame(
            self::TEXT,
            $this->cFT->apply(new \stdClass(), self::TEXT)
        );
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidArgumentCTF(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->cTF->apply(new \stdClass(), self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidArgumentCTT(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->cTT->apply(new \stdClass(), self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidStyleCFF(): void
    {
        $this->assertSame(
            self::TEXT,
            $this->cFF->apply(self::INVALID, self::TEXT)
        );
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidStyleCFT(): void
    {
        $this->assertSame(
            self::TEXT,
            $this->cFT->apply(self::INVALID, self::TEXT)
        );
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidStyleCTF(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->cTF->apply(self::INVALID, self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidStyleCTT(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->cTT->apply(self::INVALID, self::TEXT);
    }
    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidColor256CFF(): void
    {
        $this->assertSame(
            self::TEXT,
            $this->cFF->apply(self::COLOR_2156, self::TEXT)
        );
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidColor256CFT(): void
    {
        $this->assertSame(
            self::TEXT,
            $this->cFT->apply(self::COLOR_2156, self::TEXT)
        );
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidColor256CTF(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->cTF->apply(self::COLOR_2156, self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidColor256CTT(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->cTT->apply(self::COLOR_2156, self::TEXT);
    }

    protected function setUp(): void
    {
        $this->cFF = new ConsoleColorOverride(false, false);
        $this->cFT = new ConsoleColorOverride(false, true);
        $this->cTF = new ConsoleColorOverride(true, false);
        $this->cTT = new ConsoleColorOverride(true, true);
    }
}

