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
    /** @var Cursor */
    protected $cursor;

    /** @test */
    public function values(): void
    {
        $this->assertEquals("\033[?25h\033[?0c", $this->cursor->show());
        $this->assertEquals("\033[?25l",$this->cursor->hide());
    }
    protected function setUp(): void
    {
        parent::setUp();
        $this->cursor = new Cursor();
    }

}