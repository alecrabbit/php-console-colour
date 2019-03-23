<?php
/**
 * User: alec
 * Date: 15.10.18
 * Time: 21:54
 */

namespace AlecRabbit\Tests\Unit;


use AlecRabbit\ConsoleColour;
use AlecRabbit\ConsoleColour\Exception\ColorException;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use PHPUnit\Framework\TestCase;

class ConsoleColorWithForceSupport extends ConsoleColour
{
    private $isSupportedForce = true;

    private $are256ColorsSupportedForce = true;

    public function setIsSupported($isSupported)
    {
        $this->isSupportedForce = $isSupported;
    }

    public function isSupported()
    {
        return $this->isSupportedForce;
    }

    public function setAre256ColorsSupported($are256ColorsSupported)
    {
        $this->are256ColorsSupportedForce = $are256ColorsSupported;
    }

    public function are256ColorsSupported(): bool
    {
        return $this->are256ColorsSupportedForce;
    }
}


class ConsoleColourTest extends TestCase
{
    /** @var ConsoleColorWithForceSupport */
    private $uut;

    /** @test */
    public function None(): void
    {
        $output = $this->uut->apply('none', 'text');
        $this->assertEquals('text', $output);
    }

    /** @test */
    public function Bold(): void
    {
        $output = $this->uut->apply('bold', 'text');
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /** @test */
    public function BoldColorsAreNotSupported(): void
    {
        $this->uut->setIsSupported(false);

        $output = $this->uut->apply('bold', 'text');
        $this->assertEquals('text', $output);
    }

    /** @test */
    public function BoldColorsAreNotSupportedButAreForced(): void
    {
        $this->uut->setIsSupported(false);
        $this->uut->setForceStyle(true);

        $output = $this->uut->apply('bold', 'text');
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /** @test */
    public function Dark(): void
    {
        $output = $this->uut->apply('dark', 'text');
        $this->assertEquals("\033[2mtext\033[0m", $output);
    }

    /** @test */
    public function BoldAndDark(): void
    {
        $output = $this->uut->apply(array('bold', 'dark'), 'text');
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /** @test */
    public function is256ColorForeground(): void
    {
        $output = $this->uut->apply('color_255', 'text');
        $this->assertEquals("\033[38;5;255mtext\033[0m", $output);
    }

    /** @test */
    public function is256ColorWithoutSupport(): void
    {
        $this->uut->setAre256ColorsSupported(false);

        $output = $this->uut->apply('color_255', 'text');
        $this->assertEquals('text', $output);
    }

    /** @test */
    public function is256ColorBackground(): void
    {
        $output = $this->uut->apply('bg_color_255', 'text');
        $this->assertEquals("\033[48;5;255mtext\033[0m", $output);
    }

    /** @test */
    public function is256ColorForegroundAndBackground(): void
    {
        $output = $this->uut->apply(array('color_200', 'bg_color_255'), 'text');
        $this->assertEquals("\033[38;5;200;48;5;255mtext\033[0m", $output);
    }

    /** @test */
    public function SetOwnTheme(): void
    {
        $this->uut->setThemes(array('bold_dark' => array('bold', 'dark')));
        $output = $this->uut->apply(array('bold_dark'), 'text');
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /** @test */
    public function AddOwnTheme(): void
    {
        $this->uut->addTheme('bold_own', 'bold');
        $output = $this->uut->apply(array('bold_own'), 'text');
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /** @test */
    public function AddOwnThemeArray(): void
    {
        $this->uut->addTheme('bold_dark', array('bold', 'dark'));
        $output = $this->uut->apply(array('bold_dark'), 'text');
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /** @test */
    public function OwnWithStyle(): void
    {
        $this->uut->addTheme('bold_dark', array('bold', 'dark'));
        $output = $this->uut->apply(array('bold_dark', 'italic'), 'text');
        $this->assertEquals("\033[1;2;3mtext\033[0m", $output);
    }

    /** @test */
    public function HasAndRemoveTheme(): void
    {
        $this->assertFalse($this->uut->hasTheme('bold_dark'));

        $this->uut->addTheme('bold_dark', array('bold', 'dark'));
        $this->assertTrue($this->uut->hasTheme('bold_dark'));

        $this->uut->removeTheme('bold_dark');
        $this->assertFalse($this->uut->hasTheme('bold_dark'));
    }

    /** @test */
    public function ApplyInvalidArgument(): void
    {
        if ($this->uut->doesThrowsOnError())
            $this->expectException(\InvalidArgumentException::class);
        $this->assertEquals('text', $this->uut->apply(new \stdClass(), 'text'));
    }

    /** @test */
    public function ApplyInvalidStyleName(): void
    {
//        if ($this->uut->doesThrowOnError())
            $this->expectException(ColorException::class);
        $this->assertEquals('text', $this->uut->apply('invalid', 'text'));

    }

    /** @test */
    public function ApplyInvalid256Color(): void
    {
//        if ($this->uut->doesThrowOnError()) {
            $this->expectException(ColorException::class);
//        }
        $this->assertEquals(
            'text',
            $this->uut->apply('color_2134', 'text')
        );
    }

    /** @test */
    public function ThemeInvalidStyle(): void
    {
        $this->expectException(InvalidStyleException::class);
        $this->uut->addTheme('invalid', array('invalid'));
    }

    /** @test */
    public function ForceStyle():void
    {
        $this->assertFalse($this->uut->isStyleForced());
        $this->uut->setForceStyle(true);
        $this->assertTrue($this->uut->isStyleForced());
    }

    /** @test */
    public function GetPossibleStyles(): void
    {
        $this->assertIsArray($this->uut->getPossibleStyles());
        $this->assertNotEmpty($this->uut->getPossibleStyles());
    }

    /** @test */
    public function Escaped(): void
    {
        $this->uut->addTheme('bold_green', ['bold', 'green']);

        $this->assertEquals(
            '\033[1;32mbold green text\033[0m',
            $this->uut->applyEscaped('bold_green','bold green text')
        );
        $this->assertEquals(
             "\033[1;32mbold green text\033[0m",
            $this->uut->apply('bold_green','bold green text')
        );
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
        $this->uut = new ConsoleColorWithForceSupport();
        $this->uut->doNotThrowOnError();
    }

}
