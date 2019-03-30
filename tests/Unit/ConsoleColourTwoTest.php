<?php

namespace AlecRabbit\Tests\ConsoleColour;


use AlecRabbit\ConsoleColour\ConsoleColour;
use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\Tests\ConsoleColourWithForceSupport;
use AlecRabbit\Tests\Helper;
use PHPUnit\Framework\TestCase;

class ConsoleColourTwoTest extends TestCase
{
    /** @var ConsoleColourWithForceSupport */
    private $uut;

    /**
     * @test
     * @throws \Throwable
     */
    public function None(): void
    {
        $output = $this->uut->apply(Styles::NONE, 'text');
        $this->assertEquals('text', $output);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function Bold(): void
    {
        $output = $this->uut->apply(Styles::BOLD, 'text');
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function BoldColorsAreNotSupported(): void
    {
        $this->uut->setIsSupported(false);

        $output = $this->uut->apply(Styles::BOLD, 'text');
        $this->assertEquals('text', $output);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function BoldColorsAreNotSupportedButAreForced(): void
    {
        $this->uut->setIsSupported(false);
        $this->uut->setForceStyle(true);

        $output = $this->uut->apply(Styles::BOLD, 'text');
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function Dark(): void
    {
        $output = $this->uut->apply(Styles::DARK, 'text');
        $this->assertEquals("\033[2mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function BoldAndDark(): void
    {
        $output = $this->uut->apply([Styles::BOLD, Styles::DARK], 'text');
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function is256ColorForeground(): void
    {
        $output = $this->uut->apply('color_255', 'text');
        $this->assertEquals("\033[38;5;255mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function is256ColorWithoutSupport(): void
    {
        $this->uut->setAre256ColorsSupported(false);

        $output = $this->uut->apply('color_255', 'text');
        $this->assertEquals('text', $output);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function is256ColorBackground(): void
    {
        $output = $this->uut->apply('bg_color_255', 'text');
        $this->assertEquals("\033[48;5;255mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function is256ColorForegroundAndBackground(): void
    {
        $output = $this->uut->apply(['color_200', 'bg_color_255'], 'text');
        $this->assertEquals("\033[38;5;200;48;5;255mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function SetOwnTheme(): void
    {
        $this->uut->setThemes(['bold_dark' => [Styles::BOLD, Styles::DARK]]);
        $output = $this->uut->apply(['bold_dark'], 'text');
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function AddOwnTheme(): void
    {
        $this->uut->addTheme('bold_own', Styles::BOLD);
        $output = $this->uut->apply(['bold_own'], 'text');
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function AddOwnThemeArray(): void
    {
        $this->uut->addTheme('bold_dark', [Styles::BOLD, Styles::DARK]);
        $output = $this->uut->apply(['bold_dark'], 'text');
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function OwnWithStyle(): void
    {
        $this->uut->addTheme('bold_dark', [Styles::BOLD, Styles::DARK]);
        $output = $this->uut->apply(['bold_dark', Styles::ITALIC], 'text');
        $this->assertEquals("\033[1;2;3mtext\033[0m", $output);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function HasAndRemoveTheme(): void
    {
        $this->assertFalse($this->uut->hasTheme('bold_dark'));

        $this->uut->addTheme('bold_dark', [Styles::BOLD, Styles::DARK]);
        $this->assertTrue($this->uut->hasTheme('bold_dark'));

        $this->uut->removeTheme('bold_dark');
        $this->assertFalse($this->uut->hasTheme('bold_dark'));
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function ApplyInvalidArgument(): void
    {
        if ($this->uut->doesThrowsOnError()) {
            $this->expectException(\InvalidArgumentException::class);
        }
        $this->assertEquals('text', $this->uut->apply(new \stdClass(), 'text'));
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function ApplyInvalidStyleName(): void
    {
        if ($this->uut->doesThrowsOnError()) {
            $this->expectException(InvalidStyleException::class);
        }
        $this->assertEquals('text', $this->uut->apply('invalid', 'text'));

    }

    /**
     * @test
     * @throws \Throwable
     */
    public function ApplyInvalid256Color(): void
    {
        if ($this->uut->doesThrowsOnError()) {
            $this->expectException(InvalidStyleException::class);
        }
        $this->assertEquals(
            'text',
            $this->uut->apply('color_2134', 'text')
        );
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function ThemeInvalidStyle(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->uut->addTheme('invalid', ['invalid']);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function ForceStyle(): void
    {
        $this->assertFalse($this->uut->isStyleForced());
        $this->uut->setForceStyle(true);
        $this->assertTrue($this->uut->isStyleForced());
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function GetPossibleStyles(): void
    {
        $this->assertIsArray($this->uut->getPossibleStyles());
        $this->assertNotEmpty($this->uut->getPossibleStyles());
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function Escaped(): void
    {
        $this->uut->addTheme('bold_red', [Styles::BOLD, Styles::RED]);

        $str = $this->uut->apply('bold_red', 'bold red text');
        $this->assertEquals('\033[1;31mbold red text\033[0m', Helper::stripEscape($str));
        $this->assertEquals("\033[1;31mbold red text\033[0m", $str);
    }

    /**
     * @test
     */
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
        $this->uut = new ConsoleColourWithForceSupport();
    }

}
