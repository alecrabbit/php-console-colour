<?php
/**
 * User: alec
 * Date: 24.12.18
 * Time: 15:17
 */
declare(strict_types=1);

namespace AlecRabbit;

use AlecRabbit\Contracts\ThemesInterface;
use AlecRabbit\Exception\ColorException;
use AlecRabbit\Exception\InvalidStyleException;

class Themed extends ConsoleColour implements ThemesInterface
{
    /** @var bool */
    private $doColorize;

    /**
     * Themed constructor.
     * @param bool $colorize
     * @throws InvalidStyleException
     */
    public function __construct(bool $colorize = false)
    {
        $this->doColorize = $colorize;
        parent::__construct();
        $this->setDefaultThemes();
    }

    /**
     * @throws Exception\InvalidStyleException
     */
    protected function setDefaultThemes(): void
    {
        $this->addTheme(static::DARK, 'dark');
        $this->addTheme(static::COMMENT, 'yellow');
        $this->addTheme(static::INFO, 'green');
        $this->addTheme(static::RED, 'red');
    }

    /**
     * @param string $text
     * @return string
     * @throws \Throwable
     */
    public function comment(string $text): string
    {
        return
            $this->apply(static::COMMENT, $text);
    }

    /**
     * @param string $text
     * @return string
     * @throws \Throwable
     */
    public function yellow(string $text): string
    {
        return
            $this->apply(static::COMMENT, $text);
    }

    /**
     * @param array|string $style
     * @param string $text
     * @return string
     * @throws \Throwable
     */
    public function apply($style, $text): string
    {
        try {
            return $this->doColorize ? parent::apply($style, $text) : $text;
        } catch (ColorException $e) {
            // do nothing
        }
        return $text;
    }

    /**
     * @param string $text
     * @return string
     * @throws \Throwable
     */
    public function red(string $text): string
    {
        return
            $this->apply(static::RED, $text);
    }

    /**
     * @param string $text
     * @return string
     * @throws \Throwable
     */
    public function info(string $text): string
    {
        return
            $this->apply(static::INFO, $text);
    }

    /**
     * @param string $text
     * @return string
     * @throws \Throwable
     */
    public function green(string $text): string
    {
        return
            $this->apply(static::INFO, $text);
    }

    /**
     * @param string $text
     * @return string
     * @throws \Throwable
     */
    public function dark(string $text): string
    {
        return
            $this->apply(static::DARK, $text);
    }
}
