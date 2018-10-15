<?php
/**
 * User: alec
 * Date: 15.10.18
 * Time: 21:33
 */

namespace AlecRabbit;


use JakubOnderka\PhpConsoleColor\ConsoleColor;

class ConsoleColour extends ConsoleColor
{
    /** @var bool */
    protected $force256Colors;

    /** @var bool */
    protected $throwOnError;

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

    public function are256ColorsSupported()
    {
        return
            $this->force256Colors ?: (parent::are256ColorsSupported() || $this->areInDocker256ColorsSupported());
    }

    protected function areInDocker256ColorsSupported(): bool
    {
        return (strpos(getenv('DOCKER_TERM'), '256color') !== false);
    }

    public function doNotThrowOnError(): ConsoleColour
    {
        $this->throwOnError = false;
        return $this;
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
            return
                parent::apply($style, $text);
        } catch (\Throwable $e) {
            if ($this->throwOnError)
                throw $e;
            else
                $this->processException($e);
        }
        return $text;
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

    private function processException(\Throwable $e)
    {
        if (defined('APP_DEBUG') && APP_DEBUG) {
            dump(brackets(get_class($e)) . ' ' . $e->getMessage());
            dump($e->getTraceAsString());
            if (defined('DEBUG_DUMP_EXCEPTION_CLASS') && DEBUG_DUMP_EXCEPTION_CLASS) {
                dump($e);
            }
        }
    }

    public function doesThrowOnError(): bool
    {
        return $this->throwOnError;
    }
}