<?php

namespace AlecRabbit\Tests\ConsoleColour;

use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\Tests\ConsoleColorOverride;
use PHPUnit\Framework\TestCase;

class ConsoleColorTest extends TestCase
{

    public const STYLES_COUNT = 45;
    public const TEXT = 'Text to apply style to.';

    public const COLOR_2156 = 'color_2156';
    public const INVALID = 'invalid';
    public const BOLD_DARK = 'bold_dark';
    public const THEMES = [self::BOLD_DARK => self::THEME_STYLES];
    public const THEME_STYLES = [Styles::BOLD, Styles::DARK];

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
    public function getPossibleStyles(): void
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
    public function themeInvalidStyleCFF(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->cFF->addTheme(self::INVALID, [self::INVALID]);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function themeInvalidStyleCFT(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->cFT->addTheme(self::INVALID, [self::INVALID]);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function themeInvalidStyleCTF(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->cTF->addTheme(self::INVALID, [self::INVALID]);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function themeInvalidStyleCTT(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->cTT->addTheme(self::INVALID, [self::INVALID]);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function applyInvalidArgument(): void
    {
        $this->assertSame(
            self::TEXT,
            $this->cFF->apply(new \stdClass(), self::TEXT)
        );
        $this->assertSame(
            self::TEXT,
            $this->cFT->apply(new \stdClass(), self::TEXT)
        );
        $this->expectException(\InvalidArgumentException::class);
        $this->cTF->apply(new \stdClass(), self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function applyInvalidArgumentCTT(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->cTT->apply(new \stdClass(), self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function applyInvalidStyle(): void
    {
        $this->assertSame(
            self::TEXT,
            $this->cFF->apply(self::INVALID, self::TEXT)
        );
        $this->assertSame(
            self::TEXT,
            $this->cFT->apply(self::INVALID, self::TEXT)
        );
        $this->expectException(InvalidStyleException::class);
        $this->cTF->apply(self::INVALID, self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function applyInvalidStyleCTT(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->cTT->apply(self::INVALID, self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function applyInvalidColor256(): void
    {
        $this->assertSame(
            self::TEXT,
            $this->cFF->apply(self::COLOR_2156, self::TEXT)
        );
        $this->assertSame(
            self::TEXT,
            $this->cFT->apply(self::COLOR_2156, self::TEXT)
        );

        $this->expectException(InvalidStyleException::class);
        $this->cTF->apply(self::COLOR_2156, self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function applyInvalidColor256CTT(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->cTT->apply(self::COLOR_2156, self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ownThemeWithAdditionalStyle(): void
    {
        $this->cFF->addTheme(self::BOLD_DARK, self::THEME_STYLES);
        $this->cFT->addTheme(self::BOLD_DARK, self::THEME_STYLES);
        $this->cTF->addTheme(self::BOLD_DARK, self::THEME_STYLES);
        $this->cTT->addTheme(self::BOLD_DARK, self::THEME_STYLES);

        $this->assertSame(
            self::TEXT,
            $this->cFF->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );
        $this->assertSame(
            self::TEXT,
            $this->cFT->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );
        $this->assertSame(
            $this->helperGetColorStr([1, 2, 3]),
            $this->cTF->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );
        $this->assertSame(
            $this->helperGetColorStr([1, 2, 3]),
            $this->cTT->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Theme [' . self::BOLD_DARK . '] is already set.');
        $this->cFF->addTheme(self::BOLD_DARK, self::THEME_STYLES);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function setOwnTheme(): void
    {
        $this->cFF->setThemes(self::THEMES);
        $this->cFT->setThemes(self::THEMES);
        $this->cTF->setThemes(self::THEMES);
        $this->cTT->setThemes(self::THEMES);
        $this->assertSame(
            self::TEXT,
            $this->cFF->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );
        $this->assertSame(
            self::TEXT,
            $this->cFT->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );
        $this->assertSame(
            $this->helperGetColorStr([1, 2, 3]),
            $this->cTF->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );
        $this->assertSame(
            $this->helperGetColorStr([1, 2, 3]),
            $this->cTT->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function hasThemeAddThemeRemoveTheme(): void
    {
        $this->assertFalse($this->cFF->hasTheme(self::BOLD_DARK));
        $this->assertFalse($this->cFT->hasTheme(self::BOLD_DARK));
        $this->assertFalse($this->cTF->hasTheme(self::BOLD_DARK));
        $this->assertFalse($this->cTT->hasTheme(self::BOLD_DARK));

        $this->cFF->addTheme(self::BOLD_DARK, self::THEME_STYLES);
        $this->cFT->addTheme(self::BOLD_DARK, self::THEME_STYLES);
        $this->cTF->addTheme(self::BOLD_DARK, self::THEME_STYLES);
        $this->cTT->addTheme(self::BOLD_DARK, self::THEME_STYLES);

        $this->assertTrue($this->cFF->hasTheme(self::BOLD_DARK));
        $this->assertTrue($this->cFT->hasTheme(self::BOLD_DARK));
        $this->assertTrue($this->cTF->hasTheme(self::BOLD_DARK));
        $this->assertTrue($this->cTT->hasTheme(self::BOLD_DARK));

        $this->cFF->removeTheme(self::BOLD_DARK);
        $this->cFT->removeTheme(self::BOLD_DARK);
        $this->cTF->removeTheme(self::BOLD_DARK);
        $this->cTT->removeTheme(self::BOLD_DARK);

        $this->assertFalse($this->cFF->hasTheme(self::BOLD_DARK));
        $this->assertFalse($this->cFT->hasTheme(self::BOLD_DARK));
        $this->assertFalse($this->cTF->hasTheme(self::BOLD_DARK));
        $this->assertFalse($this->cTT->hasTheme(self::BOLD_DARK));
    }


    protected function setUp(): void
    {
        $this->cFF = new ConsoleColorOverride(false, false);
        $this->cFT = new ConsoleColorOverride(false, true);
        $this->cTF = new ConsoleColorOverride(true, false);
        $this->cTT = new ConsoleColorOverride(true, true);
    }
}

