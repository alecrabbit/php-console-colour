<?php
/**
 * User: alec
 * Date: 15.10.18
 * Time: 21:33
 */

namespace AlecRabbit\ConsoleColour;

use AlecRabbit\ConsoleColour\Exception\ColorException;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\Traits\DoesProcessException;
use JakubOnderka\PhpConsoleColor\ConsoleColor;

class ConsoleColour extends ConsoleColor
{
    use DoesProcessException;

    /** @var bool */
    protected $force256Colors;

    public function __construct(?bool $force256Colors = null)
    {
        parent::__construct();
        $this->force256Colors = $force256Colors ?? false;
        $this->throwOnError = true;
    }

    public function force256Colors(): ConsoleColour
    {
        if (!$this->are256ColorsForced()) {
            $this->force256Colors = $this->are256ColorsSupported() ? false : true;
        }
        return $this;
    }

    public function are256ColorsForced(): bool
    {
        return $this->force256Colors;
    }

    public function are256ColorsSupported(): bool
    {
        return
            $this->force256Colors ?: (parent::are256ColorsSupported() || $this->areInDocker256ColorsSupported());
    }

    protected function areInDocker256ColorsSupported(): bool
    {
        return (strpos((string)getenv('DOCKER_TERM'), '256color') !== false);
    }

    /**
     * @param array|string $style
     * @param string $text
     * @return string
     * @throws \Throwable
     */
    public function applyEscaped($style, $text): string
    {
        $text = $this->apply($style, $text);
        return
            str_replace("\e", '\033', $text);
    }

    /**
     * @param array|string $style
     * @param string $text
     * @return string
     * @throws ColorException
     * @throws \Throwable
     */
    public function apply($style, $text): string
    {
        try {
            return
                parent::apply($style, $text);
        } catch (\JakubOnderka\PhpConsoleColor\InvalidStyleException $e) {
            throw new ColorException($e->getMessage(), (int)$e->getCode(), $e);
        } catch (\Throwable $e) {
            $this->processException($e);
        }
        return $text;
    }

    /**
     * @param string $name
     * @param array|string $styles
     * @throws \AlecRabbit\ConsoleColour\Exception\InvalidStyleException
     */
    public function addTheme($name, $styles): void
    {
        try {
            parent::addTheme($name, $styles);
        } catch (\JakubOnderka\PhpConsoleColor\InvalidStyleException $e) {
            throw new InvalidStyleException($e->getMessage(), (int)$e->getCode(), $e);
        }
    }
}
