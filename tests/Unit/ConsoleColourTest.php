<?php

namespace AlecRabbit\Tests\Unit;

use AlecRabbit\ConsoleColour\ConsoleColour;
use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\Tests\ConsoleColourWithForceSupport;
use AlecRabbit\Tests\Helper;
use PHPUnit\Framework\TestCase;

class ConsoleColourTest extends TestCase
{
    public const STYLES_COUNT = 43;

    /** @var ConsoleColourWithForceSupport */
    private $color;

    /** @test
     * @throws \Throwable
     */
    public function None(): void
    {
        $output = $this->color->apply(Styles::NONE, 'text');
        $this->assertEquals('text', $output);
    }

    /** @test
     * @throws \Throwable
     */
    public function Bold(): void
    {
        $output = $this->color->apply(Styles::BOLD, 'text');
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /** @test
     * @throws \Throwable
     */
    public function BoldColorsAreNotSupported(): void
    {
        $this->color->setIsSupported(false);

        $output = $this->color->apply(Styles::BOLD, 'text');
        $this->assertEquals('text', $output);
    }

    /** @test
     * @throws \Throwable
     */
    public function BoldColorsAreNotSupportedButAreForced(): void
    {
        $this->color->setIsSupported(false);
        $this->color->setForceStyle(true);

        $output = $this->color->apply(Styles::BOLD, 'text');
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /** @test
     * @throws \Throwable
     */
    public function Dark(): void
    {
        $output = $this->color->apply(Styles::DARK, 'text');
        $this->assertEquals("\033[2mtext\033[0m", $output);
    }

    /** @test
     * @throws \Throwable
     */
    public function BoldAndDark(): void
    {
        $output = $this->color->apply([Styles::BOLD, Styles::DARK], 'text');
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /** @test
     * @throws \Throwable
     */
    public function is256ColorForeground(): void
    {
        $output = $this->color->apply('color_255', 'text');
        $this->assertEquals("\033[38;5;255mtext\033[0m", $output);
    }

    /** @test
     * @throws \Throwable
     */
    public function is256ColorWithoutSupport(): void
    {
        $this->color->setAre256ColorsSupported(false);

        $output = $this->color->apply('color_255', 'text');
        $this->assertEquals('text', $output);
    }

    /** @test
     * @throws \Throwable
     */
    public function is256ColorBackground(): void
    {
        $output = $this->color->apply('bg_color_255', 'text');
        $this->assertEquals("\033[48;5;255mtext\033[0m", $output);
    }

    /** @test
     * @throws \Throwable
     */
    public function is256ColorForegroundAndBackground(): void
    {
        $output = $this->color->apply(['color_200', 'bg_color_255'], 'text');
        $this->assertEquals("\033[38;5;200;48;5;255mtext\033[0m", $output);
    }

    /** @test
     * @throws \Throwable
     */
    public function SetOwnTheme(): void
    {
        $this->color->setThemes(['bold_dark' => [Styles::BOLD, Styles::DARK]]);
        $output = $this->color->apply(['bold_dark'], 'text');
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /** @test
     * @throws \Throwable
     */
    public function AddOwnTheme(): void
    {
        $this->color->addTheme('bold_own', Styles::BOLD);
        $output = $this->color->apply(['bold_own'], 'text');
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /** @test
     * @throws \Throwable
     */
    public function AddOwnThemeArray(): void
    {
        $this->color->addTheme('bold_dark', [Styles::BOLD, Styles::DARK]);
        $output = $this->color->apply(['bold_dark'], 'text');
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /** @test
     * @throws \Throwable
     */
    public function OwnWithStyle(): void
    {
        $this->color->addTheme('bold_dark', [Styles::BOLD, Styles::DARK]);
        $output = $this->color->apply(['bold_dark', Styles::ITALIC], 'text');
        $this->assertEquals("\033[1;2;3mtext\033[0m", $output);
    }

    /** @test
     * @throws \Throwable
     */
    public function HasAndRemoveTheme(): void
    {
        $this->assertFalse($this->color->hasTheme('bold_dark'));

        $this->color->addTheme('bold_dark', [Styles::BOLD, Styles::DARK]);
        $this->assertTrue($this->color->hasTheme('bold_dark'));

        $this->color->removeTheme('bold_dark');
        $this->assertFalse($this->color->hasTheme('bold_dark'));
    }

    /** @test
     * @throws \Throwable
     */
    public function ApplyInvalidArgument(): void
    {
        if ($this->color->doesThrowsOnError()) {
            $this->expectException(\InvalidArgumentException::class);
        }
        $this->assertEquals('text', $this->color->apply(new \stdClass(), 'text'));
    }

    /** @test
     * @throws \Throwable
     */
    public function ApplyInvalidStyleName(): void
    {
//        if ($this->uut->doesThrowOnError())
        $this->expectException(InvalidStyleException::class);
        $this->assertEquals('text', $this->color->apply('invalid', 'text'));

    }

    /** @test
     * @throws \Throwable
     */
    public function ApplyInvalid256Color(): void
    {
//        if ($this->uut->doesThrowOnError()) {
        $this->expectException(InvalidStyleException::class);
//        }
        $this->assertEquals(
            'text',
            $this->color->apply('color_2134', 'text')
        );
    }

    /** @test
     * @throws \Throwable
     */
    public function ThemeInvalidStyle(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->color->addTheme('invalid', ['invalid']);
    }

    /** @test */
    public function ForceStyle(): void
    {
        $this->assertFalse($this->color->isStyleForced());
        $this->color->setForceStyle(true);
        $this->assertTrue($this->color->isStyleForced());
    }

    /** @test */
    public function GetPossibleStyles(): void
    {
        $this->assertIsArray($this->color->getPossibleStyles());
        $this->assertNotEmpty($this->color->getPossibleStyles());
        $this->assertCount(self::STYLES_COUNT, $this->color->getPossibleStyles());
    }

    /** @test
     * @throws \Throwable
     */
    public function Escaped(): void
    {
        $this->color->addTheme('bold_green', [Styles::BOLD, Styles::GREEN]);

        $str = $this->color->apply('bold_green', 'bold green text');
        $this->assertEquals('\033[1;32mbold green text\033[0m', Helper::stripEscape($str));
        $this->assertEquals("\033[1;32mbold green text\033[0m", $str);
    }

    /** @test */
    public function Separate(): void
    {
        $c = new ConsoleColour();
        $this->assertFalse($c->are256ColorsForced());
        $c->force256Colors();
        $this->assertTrue($c->are256ColorsSupported());
        $d = new ConsoleColour(true);
        $this->assertTrue($d->are256ColorsForced());
        $this->assertTrue($d->are256ColorsSupported());
    }

    protected function setUp(): void
    {
        $this->color = new ConsoleColourWithForceSupport();
//        $this->uut->doNotThrowOnError();
    }

}
