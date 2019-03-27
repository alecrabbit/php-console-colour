<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Unit;

use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\Tests\ExtendedTheme;
use PHPUnit\Framework\TestCase;

class ExtendedThemeTest extends TestCase
{
    public const THEMES = [
        'fire' => "\033[91;1;107;3m",
        'new' => "\033[96;40;4m",
    ];

    /** @var ExtendedTheme */
    private $colorized;
    /** @var ExtendedTheme */
    private $nonColorized;

    /** @test */
    public function badMethodCall(): void
    {
        $text = 'sample';
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('Unknown method call [AlecRabbit\Tests\ExtendedTheme::unknownMethod].');
        $this->assertEquals($text, $this->colorized->unknownMethod($text));
    }

    /** @test */
    public function wrongArgumentCount(): void
    {
        $text = 'sample';
        $this->assertEquals($text, $this->nonColorized->fire($text));
        $this->expectException(\ArgumentCountError::class);
        $this->expectExceptionMessage('Method [AlecRabbit\Tests\ExtendedTheme::red] accepts only one argument.');
        $this->assertEquals($text, $this->colorized->red($text, $text));
    }

    /** @test */
    public function multi(): void
    {
        $text = 'SmPlTxT';
        $this->assertInstanceOf(ExtendedTheme::class, $this->colorized);
        $this->assertInstanceOf(ExtendedTheme::class, $this->nonColorized);
        foreach (self::THEMES as $methodName => $theme) {
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
        $this->colorized = new ExtendedTheme(true);
        $this->nonColorized = new ExtendedTheme(false);
    }

}