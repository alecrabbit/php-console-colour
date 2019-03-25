<?php

namespace AlecRabbit\Tests\Unit;

use JakubOnderka\PhpConsoleColor\ConsoleColor;
use PHPUnit\Framework\TestCase;
use JakubOnderka\PhpConsoleColor\InvalidStyleException;

class ConsoleColorTest extends TestCase
{
    public const TEXT = 'text';

    /** @var ConsoleColorWithForceSupport */
    private $uut;

    protected function setUp():void
    {
        $this->uut = new ConsoleColorWithForceSupport();
    }

    /**
     * @throws \AlecRabbit\ConsoleColour\Exception\ColorException
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     * @throws \Throwable
     */
    public function testNone()
    {
        $output = $this->uut->apply('none', self::TEXT);
        $this->assertEquals(self::TEXT, $output);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function testBold()
    {
        $output = $this->uut->apply('bold', self::TEXT);
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function testBoldColorsAreNotSupported()
    {
        $this->uut->setIsSupported(false);

        $output = $this->uut->apply('bold', self::TEXT);
        $this->assertEquals(self::TEXT, $output);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function testBoldColorsAreNotSupportedButAreForced()
    {
        $this->uut->setIsSupported(false);
        $this->uut->setForceStyle(true);

        $output = $this->uut->apply('bold', self::TEXT);
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function testDark()
    {
        $output = $this->uut->apply('dark', self::TEXT);
        $this->assertEquals("\033[2mtext\033[0m", $output);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function testBoldAndDark()
    {
        $output = $this->uut->apply(array('bold', 'dark'), self::TEXT);
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function test256ColorForeground()
    {
        $output = $this->uut->apply('color_255', self::TEXT);
        $this->assertEquals("\033[38;5;255mtext\033[0m", $output);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function test256ColorWithoutSupport()
    {
        $this->uut->setAre256ColorsSupported(false);

        $output = $this->uut->apply('color_255', self::TEXT);
        $this->assertEquals(self::TEXT, $output);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function test256ColorBackground()
    {
        $output = $this->uut->apply('bg_color_255', self::TEXT);
        $this->assertEquals("\033[48;5;255mtext\033[0m", $output);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function test256ColorForegroundAndBackground()
    {
        $output = $this->uut->apply(array('color_200', 'bg_color_255'), self::TEXT);
        $this->assertEquals("\033[38;5;200;48;5;255mtext\033[0m", $output);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function testSetOwnTheme()
    {
        $this->uut->setThemes(array('bold_dark' => array('bold', 'dark')));
        $output = $this->uut->apply(array('bold_dark'), self::TEXT);
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function testAddOwnTheme()
    {
        $this->uut->addTheme('bold_own', 'bold');
        $output = $this->uut->apply(array('bold_own'), self::TEXT);
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function testAddOwnThemeArray()
    {
        $this->uut->addTheme('bold_dark', array('bold', 'dark'));
        $output = $this->uut->apply(array('bold_dark'), self::TEXT);
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function testOwnWithStyle()
    {
        $this->uut->addTheme('bold_dark', array('bold', 'dark'));
        $output = $this->uut->apply(array('bold_dark', 'italic'), self::TEXT);
        $this->assertEquals("\033[1;2;3mtext\033[0m", $output);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function testHasAndRemoveTheme()
    {
        $this->assertFalse($this->uut->hasTheme('bold_dark'));

        $this->uut->addTheme('bold_dark', array('bold', 'dark'));
        $this->assertTrue($this->uut->hasTheme('bold_dark'));

        $this->uut->removeTheme('bold_dark');
        $this->assertFalse($this->uut->hasTheme('bold_dark'));
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function testApplyInvalidArgument()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->uut->apply(new \stdClass(), self::TEXT);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function testApplyInvalidStyleName()
    {
        $this->expectException(InvalidStyleException::class);
        $this->uut->apply('invalid', self::TEXT);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function testApplyInvalid256Color()
    {
        $this->expectException(InvalidStyleException::class);
        $this->uut->apply('color_2134', self::TEXT);
    }

    /**
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function testThemeInvalidStyle()
    {
        $this->expectException(InvalidStyleException::class);
        $this->uut->addTheme('invalid', array('invalid'));
    }

    public function testForceStyle()
    {
        $this->assertFalse($this->uut->isStyleForced());
        $this->uut->setForceStyle(true);
        $this->assertTrue($this->uut->isStyleForced());
    }

    public function testGetPossibleStyles()
    {
        $possibleStyles = $this->uut->getPossibleStyles();
        $this->assertIsArray($possibleStyles);
        $this->assertNotEmpty($possibleStyles);
        $this->assertCount(42, $possibleStyles);
    }
}

