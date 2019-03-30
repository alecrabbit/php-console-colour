<?php

namespace AlecRabbit\Tests\ConsoleColour;

use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\Tests\ConsoleColorWithForceSupport;
use PHPUnit\Framework\TestCase;

class ConsoleColorTest extends TestCase
{
    public const TEXT = 'text';
    public const STYLES_COUNT = 44;

    /** @var ConsoleColorWithForceSupport */
    private $color;

    /**
     * @test
     * @throws \Throwable
     */
    public function None(): void
    {
        $output = $this->color->apply(Styles::NONE, self::TEXT);
        $this->assertEquals(self::TEXT, $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function Bold(): void
    {
        $output = $this->color->apply(Styles::BOLD, self::TEXT);
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function BoldColorsAreNotSupported(): void
    {
        $this->color->setIsSupported(false);

        $output = $this->color->apply(Styles::BOLD, self::TEXT);
        $this->assertEquals(self::TEXT, $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function BoldColorsAreNotSupportedButAreForced(): void
    {
        $this->color->setIsSupported(false);
        $this->color->setForceStyle(true);

        $output = $this->color->apply(Styles::BOLD, self::TEXT);
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function Dark(): void
    {
        $output = $this->color->apply(Styles::DARK, self::TEXT);
        $this->assertEquals("\033[2mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function BoldAndDark(): void
    {
        $output = $this->color->apply([Styles::BOLD, Styles::DARK], self::TEXT);
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function is256ColorForeground(): void
    {
        $output = $this->color->apply('color_255', self::TEXT);
        $this->assertEquals("\033[38;5;255mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function is256ColorWithoutSupport(): void
    {
        $this->color->setAre256ColorsSupported(false);

        $output = $this->color->apply('color_255', self::TEXT);
        $this->assertEquals(self::TEXT, $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function is256ColorBackground(): void
    {
        $output = $this->color->apply('bg_color_255', self::TEXT);
        $this->assertEquals("\033[48;5;255mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function is256ColorForegroundAndBackground(): void
    {
        $output = $this->color->apply(['color_200', 'bg_color_255'], self::TEXT);
        $this->assertEquals("\033[38;5;200;48;5;255mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function SetOwnTheme(): void
    {
        $this->color->setThemes(['bold_dark' => [Styles::BOLD, Styles::DARK]]);
        $output = $this->color->apply(['bold_dark'], self::TEXT);
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function AddOwnTheme(): void
    {
        $this->color->addTheme('bold_own', Styles::BOLD);
        $output = $this->color->apply(['bold_own'], self::TEXT);
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function AddOwnThemeArray(): void
    {
        $this->color->addTheme('bold_dark', [Styles::BOLD, Styles::DARK]);
        $output = $this->color->apply(['bold_dark'], self::TEXT);
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function OwnWithStyle(): void
    {
        $this->color->addTheme('bold_dark', [Styles::BOLD, Styles::DARK]);
        $output = $this->color->apply(['bold_dark', Styles::ITALIC], self::TEXT);
        $this->assertEquals("\033[1;2;3mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function HasAndRemoveTheme(): void
    {
        $this->assertFalse($this->color->hasTheme('bold_dark'));

        $this->color->addTheme('bold_dark', [Styles::BOLD, Styles::DARK]);
        $this->assertTrue($this->color->hasTheme('bold_dark'));

        $this->color->removeTheme('bold_dark');
        $this->assertFalse($this->color->hasTheme('bold_dark'));
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidArgument(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->color->apply(new \stdClass(), self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidStyleName(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->color->apply('invalid', self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalid256Color(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->color->apply('color_2134', self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ThemeInvalidStyle(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->color->addTheme('invalid', ['invalid']);
    }

    public function testForceStyle(): void
    {
        $this->assertFalse($this->color->isStyleForced());
        $this->color->setForceStyle(true);
        $this->assertTrue($this->color->isStyleForced());
    }

    /** @test */
    public function GetPossibleStyles(): void
    {
        $possibleStyles = $this->color->getPossibleStyles();
        $this->assertIsArray($possibleStyles);
        $this->assertNotEmpty($possibleStyles);
        $this->assertCount(self::STYLES_COUNT, $possibleStyles);
    }

    /** @test */
    public function getThemes(): void
    {
        $output = $this->color->getThemes();
        $this->assertEquals([], $output);
    }


    protected function setUp(): void
    {
        $this->color = new ConsoleColorWithForceSupport();
    }
}

