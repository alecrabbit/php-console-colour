<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Unit;

use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\Tests\ExtendedStyles;
use AlecRabbit\Tests\Helper;
use PHPUnit\Framework\TestCase;

class ExtendedThemeTest extends TestCase
{
    public const THEMES = [
        'fire' => "\033[91;1;107;3m",
        'new' => "\033[96;40;4m",
    ];

    /** @var ExtendedStyles */
    private $colorized;
    /** @var ExtendedStyles */
    private $nonColorized;

    /** @test */
    public function badMethodCall(): void
    {
        $text = 'sample';
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('Unknown method call [AlecRabbit\Tests\ExtendedStyles::unknownMethod].');
        $this->assertEquals($text, $this->colorized->unknownMethod($text));
    }

    /** @test */
    public function wrongArgumentCount(): void
    {
        $text = 'sample';
        $this->assertEquals($text, $this->nonColorized->fire($text));
        $this->expectException(\ArgumentCountError::class);
        $this->expectExceptionMessage('Method [AlecRabbit\Tests\ExtendedStyles::red] accepts only one argument.');
        $this->assertEquals($text, $this->colorized->red($text, $text));
    }

    /** @test */
    public function multi(): void
    {
        $text = 'SmPlTxT';
        $this->assertInstanceOf(ExtendedStyles::class, $this->colorized);
        $this->assertInstanceOf(ExtendedStyles::class, $this->nonColorized);
        foreach (self::THEMES as $methodName => $theme) {
            $this->assertEquals($text, $this->nonColorized->$methodName($text));
            $result = $this->colorized->$methodName($text);
            $this->assertEquals(
                Helper::stripEscape(self::THEMES[$methodName]) . $text . '\033[0m', Helper::stripEscape($result)
            );
        }
    }

    /**
     * @throws InvalidStyleException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->colorized = new ExtendedStyles(true);
        $this->nonColorized = new ExtendedStyles(false);
    }

}