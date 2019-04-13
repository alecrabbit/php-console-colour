<?php declare(strict_types=1);

namespace AlecRabbit\Tests\ConsoleColour;

use AlecRabbit\Control\Cursor;
use AlecRabbit\Tests\Helper;
use PHPUnit\Framework\TestCase;

class CursorTest extends TestCase
{
    /** @test */
    public function values(): void
    {
        $this->assertEquals(Helper::stripEscape("\033[?25h\033[?0c"), Helper::stripEscape(Cursor::show()));
        $this->assertEquals(Helper::stripEscape("\033[?25l"), Helper::stripEscape(Cursor::hide()));
        $this->assertEquals(Helper::stripEscape("\033[1A"), Helper::stripEscape(Cursor::up()));
        $this->assertEquals(Helper::stripEscape("\033[3A"), Helper::stripEscape(Cursor::up(3)));
        $this->assertEquals(Helper::stripEscape("\033[1B"), Helper::stripEscape(Cursor::down()));
        $this->assertEquals(Helper::stripEscape("\033[3B"), Helper::stripEscape(Cursor::down(3)));
        $this->assertEquals(Helper::stripEscape("\033[1C"), Helper::stripEscape(Cursor::forward()));
        $this->assertEquals(Helper::stripEscape("\033[3C"), Helper::stripEscape(Cursor::forward(3)));
        $this->assertEquals(Helper::stripEscape("\033[1D"), Helper::stripEscape(Cursor::back()));
        $this->assertEquals(Helper::stripEscape("\033[3D"), Helper::stripEscape(Cursor::back(3)));
        $this->assertEquals(Helper::stripEscape("\033[1;1f"), Helper::stripEscape(Cursor::goTo()));
        $this->assertEquals(Helper::stripEscape("\033[2;3f"), Helper::stripEscape(Cursor::goTo(3, 2)));
        $this->assertEquals(Helper::stripEscape("\033[s"), Helper::stripEscape(Cursor::savePosition()));
        $this->assertEquals(Helper::stripEscape("\033[u"), Helper::stripEscape(Cursor::restorePosition()));
        $this->assertEquals(Helper::stripEscape("\0337"), Helper::stripEscape(Cursor::save()));
        $this->assertEquals(Helper::stripEscape("\0338"), Helper::stripEscape(Cursor::restore()));
    }

    public function raw(): void
    {
        // todo
        $this->assertEquals("\033[?25h\033[?0c", Cursor::show());
        $this->assertEquals("\033[?25l", Cursor::hide());
        $this->assertEquals("\033[1A", Cursor::up());
        $this->assertEquals("\033[3A", Cursor::up(3));
        $this->assertEquals("\033[1B", Cursor::down());
        $this->assertEquals("\033[3B", Cursor::down(3));
        $this->assertEquals("\033[1C", Cursor::forward());
        $this->assertEquals("\033[3C", Cursor::forward(3));
        $this->assertEquals("\033[1D", Cursor::back());
        $this->assertEquals("\033[3D", Cursor::back(3));
        $this->assertEquals("\033[1;1f", Cursor::goTo());
        $this->assertEquals("\033[2;3f", Cursor::goTo(3, 2));
        $this->assertEquals("\033[s", Cursor::savePosition());
        $this->assertEquals("\033[u", Cursor::restorePosition());
        $this->assertEquals("\0337", Cursor::save());
        $this->assertEquals("\0338", Cursor::restore());
    }
}