<?php declare(strict_types=1);

namespace AlecRabbit\Tests\ConsoleColour;

use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\ConsoleColour\Themes\Themes;
use AlecRabbit\Tests\Helper;
use PHPUnit\Framework\TestCase;

class ThemesTest extends TestCase
{
    public const ESC = ConsoleColor::ESC_CHAR;

    public const THEMES = [
        'italic' => self::ESC . '[3m',
        'dark' => self::ESC . '[2m',
        'bold' => self::ESC . '[1m',
        'darkItalic' => self::ESC . '[2;3m',
        'white' => self::ESC . '[97m',
        'whiteBold' => self::ESC . '[97;1m',
        'comment' => self::ESC . '[33m',
        'yellow' => self::ESC . '[33m',
        'green' => self::ESC . '[32m',
        'error' => self::ESC . '[97;1;41m',
        'red' => self::ESC . '[31m',
        'info' => self::ESC . '[32m',
        'underlined' => self::ESC . '[4m',
        'underlinedBold' => self::ESC . '[4;1m',
        'underlinedItalic' => self::ESC . '[4;3m',
    ];

    /** @var \AlecRabbit\ConsoleColour\Themes\Themes */
    private $colorized;
    /** @var \AlecRabbit\ConsoleColour\Themes\Themes */
    private $nonColorized;

    /** @test */
    public function badMethodCall(): void
    {
        $text = 'sample';
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('Unknown method call [AlecRabbit\ConsoleColour\Themes\Themes::unknownMethod].');
        $this->assertEquals($text, $this->nonColorized->unknownMethod($text));
    }

    /** @test */
    public function wrongArgumentCount(): void
    {
        $text = 'sample';
        $this->expectException(\ArgumentCountError::class);
        $this->expectExceptionMessage('Method [AlecRabbit\ConsoleColour\Themes\Themes::red] accepts only one argument.');
        $this->assertEquals($text, $this->nonColorized->red($text, $text));
    }

    /** @test */
    public function multi(): void
    {
        $text = 'SmPlTxT';
        $this->assertIsArray($this->colorized->getThemes());
        $this->assertIsArray($this->nonColorized->getThemes());
        $this->assertInstanceOf(Themes::class, $this->colorized);
        $this->assertInstanceOf(Themes::class, $this->nonColorized);
        foreach (self::THEMES as $methodName => $theme) {
            $result = $this->colorized->$methodName($text);
            $this->assertEquals(
                Helper::stripEscape(self::THEMES[$methodName]) . $text . '\033[0m', Helper::stripEscape($result)
            );
            $this->assertEquals($text, $this->nonColorized->$methodName($text));
        }
    }

    /**
     * @throws InvalidStyleException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->colorized = new Themes(true);
        $this->nonColorized = new Themes(false);
    }

}