<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Unit;

use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Tests\Helper;
use PHPUnit\Framework\TestCase;

class StylesTest extends TestCase
{
    public const THEMES = [
        'italic' => "\033[3m",
        'dark' => "\033[2m",
        'bold' => "\033[1m",
        'darkItalic' => "\033[2;3m",
        'white' => "\033[97m",
        'whiteBold' => "\033[97;1m",
        'comment' => "\033[33m",
        'yellow' => "\033[33m",
        'green' => "\033[32m",
        'error' => "\033[97;1;41m",
        'red' => "\033[31m",
        'info' => "\033[32m",
        'underlined' => "\033[4m",
        'underlinedBold' => "\033[4;1m",
        'underlinedItalic' => "\033[4;3m",
    ];

    /** @var Themes */
    private $colorized;
    /** @var Themes */
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