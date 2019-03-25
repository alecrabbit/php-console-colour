<?php

namespace AlecRabbit\Tests\Unit;

use AlecRabbit\Tests\ConsoleColorWithForceSupport;
use JakubOnderka\PhpConsoleColor\InvalidStyleException;
use PHPUnit\Framework\TestCase;

class ConsoleColorTest extends TestCase
{
    public const TEXT = 'text';

    /** @var ConsoleColorWithForceSupport */
    private $uut;

    /**
     * @test
     * @throws InvalidStyleException
     * @throws \Throwable
     */
    public function None(): void
    {
        $output = $this->uut->apply('none', self::TEXT);
        $this->assertEquals(self::TEXT, $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function Bold(): void
    {
        $output = $this->uut->apply('bold', self::TEXT);
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function BoldColorsAreNotSupported(): void
    {
        $this->uut->setIsSupported(false);

        $output = $this->uut->apply('bold', self::TEXT);
        $this->assertEquals(self::TEXT, $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function BoldColorsAreNotSupportedButAreForced(): void
    {
        $this->uut->setIsSupported(false);
        $this->uut->setForceStyle(true);

        $output = $this->uut->apply('bold', self::TEXT);
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function Dark(): void
    {
        $output = $this->uut->apply('dark', self::TEXT);
        $this->assertEquals("\033[2mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function BoldAndDark(): void
    {
        $output = $this->uut->apply(['bold', 'dark'], self::TEXT);
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function is256ColorForeground(): void
    {
        $output = $this->uut->apply('color_255', self::TEXT);
        $this->assertEquals("\033[38;5;255mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function is256ColorWithoutSupport(): void
    {
        $this->uut->setAre256ColorsSupported(false);

        $output = $this->uut->apply('color_255', self::TEXT);
        $this->assertEquals(self::TEXT, $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function is256ColorBackground(): void
    {
        $output = $this->uut->apply('bg_color_255', self::TEXT);
        $this->assertEquals("\033[48;5;255mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function is256ColorForegroundAndBackground(): void
    {
        $output = $this->uut->apply(['color_200', 'bg_color_255'], self::TEXT);
        $this->assertEquals("\033[38;5;200;48;5;255mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function SetOwnTheme(): void
    {
        $this->uut->setThemes(['bold_dark' => ['bold', 'dark']]);
        $output = $this->uut->apply(['bold_dark'], self::TEXT);
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function AddOwnTheme(): void
    {
        $this->uut->addTheme('bold_own', 'bold');
        $output = $this->uut->apply(['bold_own'], self::TEXT);
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function AddOwnThemeArray(): void
    {
        $this->uut->addTheme('bold_dark', ['bold', 'dark']);
        $output = $this->uut->apply(['bold_dark'], self::TEXT);
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function OwnWithStyle(): void
    {
        $this->uut->addTheme('bold_dark', ['bold', 'dark']);
        $output = $this->uut->apply(['bold_dark', 'italic'], self::TEXT);
        $this->assertEquals("\033[1;2;3mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function HasAndRemoveTheme(): void
    {
        $this->assertFalse($this->uut->hasTheme('bold_dark'));

        $this->uut->addTheme('bold_dark', ['bold', 'dark']);
        $this->assertTrue($this->uut->hasTheme('bold_dark'));

        $this->uut->removeTheme('bold_dark');
        $this->assertFalse($this->uut->hasTheme('bold_dark'));
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidArgument(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->uut->apply(new \stdClass(), self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalidStyleName(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->uut->apply('invalid', self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ApplyInvalid256Color(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->uut->apply('color_2134', self::TEXT);
    }

    /**
     * @test
     * @throws InvalidStyleException
     */
    public function ThemeInvalidStyle(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->uut->addTheme('invalid', ['invalid']);
    }

    public function testForceStyle(): void
    {
        $this->assertFalse($this->uut->isStyleForced());
        $this->uut->setForceStyle(true);
        $this->assertTrue($this->uut->isStyleForced());
    }

    public function testGetPossibleStyles(): void
    {
        $possibleStyles = $this->uut->getPossibleStyles();
        $this->assertIsArray($possibleStyles);
        $this->assertNotEmpty($possibleStyles);
        $this->assertCount(42, $possibleStyles);
    }

    protected function setUp(): void
    {
        $this->uut = new ConsoleColorWithForceSupport();
    }
}

