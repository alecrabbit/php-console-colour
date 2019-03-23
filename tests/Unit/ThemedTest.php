<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit;

use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\Themed;
use PHPUnit\Framework\TestCase;

class ThemedTest extends TestCase
{
    /** @var Themed */
    private $colorized;
    /** @var Themed */
    private $nonColorized;

    /** @test */
    public function _red(): void
    {
        $text = 'red';
        $this->assertEquals($text, $this->nonColorized->red($text));
        $this->assertEquals("\033[31m{$text}\033[0m", $this->colorized->red($text));
    }

    /** @test */
    public function _green(): void
    {
        $text = 'red';
        $this->assertEquals($text, $this->nonColorized->green($text));
        $this->assertEquals("\033[32m{$text}\033[0m", $this->colorized->green($text));
    }

    /** @test */
    public function _yellow(): void
    {
        $text = 'red';
        $this->assertEquals($text, $this->nonColorized->yellow($text));
        $this->assertEquals("\033[33m{$text}\033[0m", $this->colorized->yellow($text));
    }

    /** @test */
    public function _dark(): void
    {
        $text = 'red';
        $this->assertEquals($text, $this->nonColorized->dark($text));
        $this->assertEquals("\033[2m{$text}\033[0m", $this->colorized->dark($text));
    }

    /** @test */
    public function _info(): void
    {
        $text = 'red';
        $this->assertEquals($text, $this->nonColorized->info($text));
        $this->assertEquals("\033[32m{$text}\033[0m", $this->colorized->info($text));
    }

    /** @test */
    public function _comment(): void
    {
        $text = 'red';
        $this->assertEquals($text, $this->nonColorized->comment($text));
        $this->assertEquals("\033[33m{$text}\033[0m", $this->colorized->comment($text));
    }

    /** @test */
    public function _invalidStyle(): void
    {
        $text = 'red';
        $this->assertEquals($text, $this->nonColorized->apply('invalid', $text));
        $this->assertEquals($text, $this->colorized->apply('invalid', $text));
    }

    /**
     * @throws InvalidStyleException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->colorized = new Themed(true);
        $this->nonColorized = new Themed(false);
    }

}