<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Unit;

use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\ConsoleColour\Theme;
use PHPUnit\Framework\TestCase;

class ThemeTest extends TestCase
{
    /** @var Theme */
    private $colorized;

    /** @var Theme */
    private $nonColorized;

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