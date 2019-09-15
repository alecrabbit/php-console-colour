<?php declare(strict_types=1);

namespace AlecRabbit\Tests\ConsoleColour;

use AlecRabbit\Cli\Tools\Core\Terminal;
use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use PHPUnit\Framework\TestCase;
use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\ESC;
use const AlecRabbit\NO_COLOR_TERMINAL;
use const AlecRabbit\TRUECOLOR_TERMINAL;

class ConsoleColorExtendedTest extends TestCase
{
    public const TEXT = 'Text to apply style to.';
    public const INVALID = 'invalid';
    public const COLOR_2156 = 'color_2156';
    public const BOLD_DARK = 'bold_dark';
    public const THEMES = [self::BOLD_DARK => self::THEME_STYLES];
    public const THEME_STYLES = [Styles::BOLD, Styles::DARK];

    /** @var ConsoleColor */
    private $c_NO_COLOR;
    /** @var ConsoleColor */
    private $c_COLOR256;
    /** @var ConsoleColor */
    private $c_COLOR16;
    /** @var ConsoleColor */
    private $c_TRUECOLOR;

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

    /** @test */
    public function isForcedAndSupported(): void
    {
        $this->assertFalse($this->c_NO_COLOR->isForced());
        $this->assertTrue($this->c_COLOR16->isForced());
        $this->assertTrue($this->c_COLOR256->isForced());
        $this->assertTrue($this->c_TRUECOLOR->isForced());

        $this->assertFalse($this->c_NO_COLOR->isSupported());
        $this->assertFalse($this->c_COLOR16->isSupported());
        $this->assertFalse($this->c_COLOR256->isSupported());
        $this->assertFalse($this->c_TRUECOLOR->isSupported());

        $this->assertFalse($this->c_NO_COLOR->isApplicable());
        $this->assertTrue($this->c_COLOR16->isApplicable());
        $this->assertTrue($this->c_COLOR256->isApplicable());
        $this->assertTrue($this->c_TRUECOLOR->isApplicable());

        $this->assertFalse($this->c_NO_COLOR->are256ColorsSupported());
        $this->assertFalse($this->c_COLOR16->are256ColorsSupported());
        $this->assertTrue($this->c_COLOR256->are256ColorsSupported());
        $this->assertTrue($this->c_TRUECOLOR->are256ColorsSupported());

        $this->assertFalse($this->c_NO_COLOR->isTrueColorSupported());
        $this->assertFalse($this->c_COLOR16->isTrueColorSupported());
        $this->assertFalse($this->c_COLOR256->isTrueColorSupported());
        $this->assertTrue($this->c_TRUECOLOR->isTrueColorSupported());
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
        [$c_NO_COLOR, $c_COLOR16, $c_COLOR256, $c_TRUECOLOR] = $expected;
        $this->assertSame($c_NO_COLOR, $this->c_NO_COLOR->apply($styles, self::TEXT));
        $this->assertSame($c_COLOR16, $this->c_COLOR16->apply($styles, self::TEXT));
        $this->assertSame($c_COLOR256, $this->c_COLOR256->apply($styles, self::TEXT));
        $this->assertSame($c_TRUECOLOR, $this->c_TRUECOLOR->apply($styles, self::TEXT));
    }

    public function multiDataProvider(): array
    {
        return [
            // [[$c_NO_COLOR, $c_COLOR16, $c_COLOR256, $c_TRUECOLOR] , styles|[styles]]
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
                    $this->helperGetColorStr([1]),
                    $this->helperGetColorStr([1]),
                    $this->helperGetColorStr([1]),
                ],
                Styles::BOLD,
            ],
            [
                [
                    self::TEXT,
                    $this->helperGetColorStr([2]),
                    $this->helperGetColorStr([2]),
                    $this->helperGetColorStr([2]),
                ],
                Styles::DARK,
            ],
            [
                [
                    self::TEXT,
                    $this->helperGetColorStr([2, 1]),
                    $this->helperGetColorStr([2, 1]),
                    $this->helperGetColorStr([2, 1]),
                ],
                [Styles::DARK, Styles::BOLD,],
            ],
            [
                [
                    self::TEXT,
                    self::TEXT,
                    $this->helperGetColorStr([38, 5, 123]),
                    $this->helperGetColorStr([38, 5, 123]),
                ],
                'color_123',
            ],
            [
                [
                    self::TEXT,
                    $this->helperGetColorStr([1]),
                    $this->helperGetColorStr([38, 5, 123, 48, 5, 13, 1]),
                    $this->helperGetColorStr([38, 5, 123, 48, 5, 13, 1]),
                ],
                ['color_123', 'bg_color_13', 1],
            ],
            [
                [
                    self::TEXT,
                    $this->helperGetColorStr([36, 1]),
                    $this->helperGetColorStr([36, 48, 5, 13, 1]),
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
        return ESC . '[' . implode(';', $styles) . 'm' . self::TEXT . ESC . '[0m';
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function themeInvalidStyleCFF(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->c_NO_COLOR->addTheme(self::INVALID, [self::INVALID]);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function themeInvalidStyleCFT(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->c_COLOR16->addTheme(self::INVALID, [self::INVALID]);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function themeInvalidStyleCTF(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->c_COLOR256->addTheme(self::INVALID, [self::INVALID]);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function themeInvalidStyleCTT(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->c_TRUECOLOR->addTheme(self::INVALID, [self::INVALID]);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function applyInvalidArgument(): void
    {
        $this->assertSame(
            self::TEXT,
            $this->c_NO_COLOR->apply(new \stdClass(), self::TEXT)
        );
        $this->expectException(\InvalidArgumentException::class);
        $this->c_COLOR16->apply(new \stdClass(), self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function applyInvalidStyle(): void
    {
        $this->assertSame(
            self::TEXT,
            $this->c_NO_COLOR->apply(self::INVALID, self::TEXT)
        );
        $this->expectException(InvalidStyleException::class);
        $this->expectExceptionMessage("Style 'invalid' is not allowed.");
        $this->c_COLOR16->apply(self::INVALID, self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function applyInvalidColor256(): void
    {
        $this->assertSame(
            self::TEXT,
            $this->c_NO_COLOR->apply(self::COLOR_2156, self::TEXT)
        );
        $this->expectException(InvalidStyleException::class);
        $this->expectExceptionMessage("Style 'color_2156' is not allowed.");
        $this->c_COLOR16->apply(self::COLOR_2156, self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ownThemeWithAdditionalStyle(): void
    {
        $this->c_NO_COLOR->addTheme(self::BOLD_DARK, self::THEME_STYLES);
        $this->c_COLOR16->addTheme(self::BOLD_DARK, self::THEME_STYLES);
        $this->c_COLOR256->addTheme(self::BOLD_DARK, self::THEME_STYLES);
        $this->c_TRUECOLOR->addTheme(self::BOLD_DARK, self::THEME_STYLES);

        $this->assertSame(
            self::TEXT,
            $this->c_NO_COLOR->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );
        $this->assertSame(
            $this->helperGetColorStr([1, 2, 3]),
            $this->c_COLOR16->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );
        $this->assertSame(
            $this->helperGetColorStr([1, 2, 3]),
            $this->c_COLOR256->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );
        $this->assertSame(
            $this->helperGetColorStr([1, 2, 3]),
            $this->c_TRUECOLOR->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Theme [' . self::BOLD_DARK . '] is already set.');
        $this->c_NO_COLOR->addTheme(self::BOLD_DARK, self::THEME_STYLES);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function setOwnTheme(): void
    {
        $this->c_NO_COLOR->setThemes(self::THEMES);
        $this->c_COLOR16->setThemes(self::THEMES);
        $this->c_COLOR256->setThemes(self::THEMES);
        $this->c_TRUECOLOR->setThemes(self::THEMES);
        $this->assertSame(
            self::TEXT,
            $this->c_NO_COLOR->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );
        $this->assertSame(
            $this->helperGetColorStr([1, 2, 3]),
            $this->c_COLOR16->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );
        $this->assertSame(
            $this->helperGetColorStr([1, 2, 3]),
            $this->c_COLOR256->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );
        $this->assertSame(
            $this->helperGetColorStr([1, 2, 3]),
            $this->c_TRUECOLOR->apply([self::BOLD_DARK, Styles::ITALIC], self::TEXT)
        );
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function hasThemeAddThemeRemoveTheme(): void
    {
        $this->assertFalse($this->c_NO_COLOR->hasTheme(self::BOLD_DARK));
        $this->assertFalse($this->c_COLOR16->hasTheme(self::BOLD_DARK));
        $this->assertFalse($this->c_COLOR256->hasTheme(self::BOLD_DARK));
        $this->assertFalse($this->c_TRUECOLOR->hasTheme(self::BOLD_DARK));

        $this->c_NO_COLOR->addTheme(self::BOLD_DARK, self::THEME_STYLES);
        $this->c_COLOR16->addTheme(self::BOLD_DARK, self::THEME_STYLES);
        $this->c_COLOR256->addTheme(self::BOLD_DARK, self::THEME_STYLES);
        $this->c_TRUECOLOR->addTheme(self::BOLD_DARK, self::THEME_STYLES);

        $this->assertTrue($this->c_NO_COLOR->hasTheme(self::BOLD_DARK));
        $this->assertTrue($this->c_COLOR16->hasTheme(self::BOLD_DARK));
        $this->assertTrue($this->c_COLOR256->hasTheme(self::BOLD_DARK));
        $this->assertTrue($this->c_TRUECOLOR->hasTheme(self::BOLD_DARK));

        $this->c_NO_COLOR->removeTheme(self::BOLD_DARK);
        $this->c_COLOR16->removeTheme(self::BOLD_DARK);
        $this->c_COLOR256->removeTheme(self::BOLD_DARK);
        $this->c_TRUECOLOR->removeTheme(self::BOLD_DARK);

        $this->assertFalse($this->c_NO_COLOR->hasTheme(self::BOLD_DARK));
        $this->assertFalse($this->c_COLOR16->hasTheme(self::BOLD_DARK));
        $this->assertFalse($this->c_COLOR256->hasTheme(self::BOLD_DARK));
        $this->assertFalse($this->c_TRUECOLOR->hasTheme(self::BOLD_DARK));
    }

    protected function setUp(): void
    {
        $this->c_NO_COLOR = new ConsoleColor(false, NO_COLOR_TERMINAL);
        $this->c_COLOR16 = new ConsoleColor(false, COLOR_TERMINAL);
        $this->c_COLOR256 = new ConsoleColor(false, COLOR256_TERMINAL);
        $this->c_TRUECOLOR = new ConsoleColor(false, TRUECOLOR_TERMINAL);
    }
}