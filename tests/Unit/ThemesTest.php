<?php declare(strict_types=1);

namespace AlecRabbit\Tests\ConsoleColour;

use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Tests\Helper;
use PHPUnit\Framework\TestCase;
use const AlecRabbit\ESC;

class ThemesTest extends TestCase
{

    public const THEMES = [
        'italic' => ESC . '[3m',
        'dark' => ESC . '[2m',
        'bold' => ESC . '[1m',
        'darkItalic' => ESC . '[2;3m',
        'white' => ESC . '[97m',
        'whiteBold' => ESC . '[97;1m',
        'comment' => ESC . '[33m',
        'yellow' => ESC . '[33m',
        'green' => ESC . '[32m',
        'error' => ESC . '[97;1;41m',
        'warning' => ESC . '[93m',
        'red' => ESC . '[31m',
        'info' => ESC . '[32m',
        'underlined' => ESC . '[4m',
        'underlinedBold' => ESC . '[4;1m',
        'underlinedItalic' => ESC . '[4;3m',

        'debug' => ESC . '[2m',
        'cyan' => ESC . '[36m',
        'magenta' => ESC . '[35m',
        'black' => ESC . '[30m',
        'blue' => ESC . '[34m',
        'lightGray' => ESC . '[37m',
        'darkGray' => ESC . '[90m',
        'lightRed' => ESC . '[91m',
        'lightGreen' => ESC . '[92m',
        'lightYellow' => ESC . '[93m',
        'lightBlue' => ESC . '[94m',
        'lightMagenta' => ESC . '[95m',
        'lightCyan' => ESC . '[96m',
        'crossed' => ESC . '[9m',
    ];

    /** @var \AlecRabbit\ConsoleColour\Themes */
    private $colorized;
    /** @var \AlecRabbit\ConsoleColour\Themes */
    private $nonColorized;

    /** @test */
    public function badMethodCall(): void
    {
        $text = 'sample';
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('Unknown method call [AlecRabbit\ConsoleColour\Themes::unknownMethod].');
        $this->assertEquals($text, $this->nonColorized->unknownMethod($text));
    }

    /** @test */
    public function none(): void
    {
        $text = 'sample';
        $this->assertEquals($text, $this->nonColorized->none($text));
        $this->assertEquals($text, $this->colorized->none($text));
    }

    /** @test */
    public function wrongArgumentCount(): void
    {
        $text = 'sample';
        $this->expectException(\ArgumentCountError::class);
        $this->expectExceptionMessage('Method [AlecRabbit\ConsoleColour\Themes::red] accepts only one argument.');
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
                Helper::stripEscape(self::THEMES[$methodName]) . $text . '\033[0m',
                Helper::stripEscape($result),
                $methodName
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