<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Unit;

use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\Tests\ExtendedThemes;
use AlecRabbit\Tests\Helper;
use PHPUnit\Framework\TestCase;

class ExtendedStylesTest extends TestCase
{
    public const STYLES = [
        'fire' => "\033[91;1;107;3m",
        'new' => "\033[96;40;4m",
    ];

    /** @var ExtendedThemes */
    private $colorized;
    /** @var ExtendedThemes */
    private $nonColorized;

    /** @test */
    public function badMethodCall(): void
    {
        $text = 'sample';
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('Unknown method call [AlecRabbit\Tests\ExtendedThemes::unknownMethod].');
        $this->assertEquals($text, $this->colorized->unknownMethod($text));
    }

    /** @test */
    public function wrongArgumentCount(): void
    {
        $text = 'sample';
        $this->assertEquals($text, $this->nonColorized->fire($text));
        $this->expectException(\ArgumentCountError::class);
        $this->expectExceptionMessage('Method [AlecRabbit\Tests\ExtendedThemes::red] accepts only one argument.');
        $this->assertEquals($text, $this->colorized->red($text, $text));
    }

    /** @test */
    public function multi(): void
    {
        $text = 'SmPlTxT';
        $this->assertInstanceOf(ExtendedThemes::class, $this->colorized);
        $this->assertInstanceOf(ExtendedThemes::class, $this->nonColorized);
        foreach (self::STYLES as $methodName => $theme) {
            $this->assertEquals($text, $this->nonColorized->$methodName($text));
            $result = $this->colorized->$methodName($text);
            $this->assertEquals(
                Helper::stripEscape(self::STYLES[$methodName]) . $text . '\033[0m', Helper::stripEscape($result)
            );
        }
    }

    /**
     * @throws InvalidStyleException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->colorized = new ExtendedThemes(true);
        $this->nonColorized = new ExtendedThemes(false);
    }

}