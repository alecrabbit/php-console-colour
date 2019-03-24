<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Unit;

use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\ConsoleColour\Theme;
use PHPUnit\Framework\TestCase;

class ThemeTest extends TestCase
{
    public const THEMES = [
        'italic' => "\033[3m",
        'dark' => "\033[2m",
        'darkItalic' => "\033[2;3m",
        'white' => "\033[97m",
        'whiteBold' => "\033[97;1m",
        'comment' => "\033[33m",
        'yellow' => "\033[33m",
        'green' => "\033[32m",
        'error' => "\033[97;1;41m",
        'red' => "\033[31m",
        'info' => "\033[32m",
        'underline' => "\033[4m",
        'underlineBold' => "\033[4;1m",
        'underlineItalic' => "\033[4;3m",
    ];

    /** @var Theme */
    private $colorized;
    /** @var Theme */
    private $nonColorized;

    /** @test */
    public function badMethodCall(): void
    {
        $text = 'sample';
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('Unknown method call [AlecRabbit\ConsoleColour\Theme::unknownMethod].');
        $this->assertEquals($text, $this->nonColorized->unknownMethod($text));
    }

    /** @test */
    public function wrongArgumentCount(): void
    {
        $text = 'sample';
        $this->expectException(\ArgumentCountError::class);
        $this->expectExceptionMessage('Method [AlecRabbit\ConsoleColour\Theme::red] accepts only one argument.');
        $this->assertEquals($text, $this->nonColorized->red($text, $text));
    }

    /** @test */
    public function multi(): void
    {
        $text = 'SmPlTxT';
        foreach (Theme::THEMES as $methodName => $theme) {
            $this->assertEquals($text, $this->nonColorized->$methodName($text));
            $result = $this->colorized->$methodName($text);
            $this->assertEquals(
                $this->stripEscape(self::THEMES[$methodName]) . $text . '\033[0m', $this->stripEscape($result)
            );
        }
    }

    /**
     * @param string $str $str
     * @return mixed
     */
    protected function stripEscape(string $str)
    {
        return str_replace("\033", '\033', $str);
    }

    /**
     * @throws InvalidStyleException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->colorized = new Theme(true);
        $this->nonColorized = new Theme(false);
    }

}