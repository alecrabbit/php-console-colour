<?php
/**
 * User: alec
 * Date: 15.10.18
 * Time: 21:33
 */

namespace AlecRabbit\ConsoleColour;

use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\Traits\DoesProcessException;

class ConsoleColour extends ConsoleColor
{
    use DoesProcessException;

    public const ESC_CHAR = "\033";

    /** @var bool */
    protected $force256Colors;

    public function __construct(?bool $force256Colors = null)
    {
        parent::__construct();
        $this->force256Colors = $force256Colors ?? false;
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
        return
            str_replace(
                self::ESC_CHAR,
                '\033',
                $this->apply($style, $text)
            );
    }

    /**
     * @param array|string $styles
     * @param string $text
     * @return string
     */
    public function apply($styles, $text): string
    {
        try {
            return parent::apply($styles, $text);
        } catch (InvalidStyleException $e) {
            // Do nothing
            // or
             $this->processException($e);
        }
        return $text;
    }
}
