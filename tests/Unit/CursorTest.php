<?php declare(strict_types=1);

namespace AlecRabbit\Tests\ConsoleColour;

use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\Control\Cursor;
use AlecRabbit\Tests\ExtendedThemes;
use AlecRabbit\Tests\Helper;
use PHPUnit\Framework\TestCase;

class CursorTest extends TestCase
{
    /** @test */
    public function values(): void
    {
        $this->assertEquals("\033[?25h\033[?0c", Cursor::show());
        $this->assertEquals("\033[?25l",Cursor::hide());
    }
}