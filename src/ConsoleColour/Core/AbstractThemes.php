<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Core;

use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use Symfony\Component\Console\Exception\InvalidArgumentException;

abstract class AbstractThemes
{
    /** @var array */
    protected $definedThemes;

    /** @var bool */
    protected $enabled = false;

    /** @var ConsoleColor */
    protected $color;
    protected $colorLevel;

    /**
     * Themed constructor.
     * @param null|bool|resource $stream
     * @param $colorLevel
     * @param null|bool $colorize
     * @throws InvalidStyleException
     */
    public function __construct($stream = null, ?int $colorLevel = null, ?bool $colorize = null)
    {
        $this->color = new ConsoleColor();
        $this->color->setStream($stream);
        $this->enabled = $this->refineColorize($colorize);
        $this->setThemes();
        $this->colorLevel = $colorLevel;
    }

    /**
     * @param null|bool $colorize
     * @return bool
     */
    protected function refineColorize(?bool $colorize): bool
    {
        if ($supported = $this->color->isSupported()) {
            return $colorize ?? $supported;
        }
        // @codeCoverageIgnoreStart
        return false;
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param bool $override
     * @throws InvalidStyleException
     */
    protected function setThemes(bool $override = false): void
    {
        foreach ($this->getThemes() as $name => $styles) {
            $this->color->addTheme($name, $styles, $override);
        }
    }

    /**
     * @return array
     *
     * @psalm-suppress RedundantConditionGivenDocblockType
     */
    public function getThemes(): array
    {
        if (null !== $this->definedThemes) {
            return $this->definedThemes;
        }
        return
            $this->definedThemes = $this->prepareThemes();
    }

    /**
     * @return array
     */
    abstract protected function prepareThemes(): array;

    /**
     * @param string $name
     * @param array $arguments
     * @return string
     * @throws \Throwable
     */
    public function __call(string $name, array $arguments): string
    {
        $this->assertMethodName($name);
        $this->assertArgs($name, $arguments);

        return
            $this->apply($this->definedThemes[$name], $arguments[0]);
    }

    /**
     * @param string $name
     */
    protected function assertMethodName(string $name): void
    {
        if (!\array_key_exists($name, $this->definedThemes)) {
            throw new \BadMethodCallException('Unknown method call [' . static::class . '::' . $name . '].');
        }
    }

    /**
     * @param string $name
     * @param array $arguments
     */
    protected function assertArgs(string $name, array $arguments): void
    {
        if (1 !== \count($arguments)) {
            throw new \ArgumentCountError(
                'Method [' . static::class . '::' . $name . '] accepts only one argument.'
            );
        }
    }

    /**
     * @param array|string $style
     * @param string $text
     * @return string
     * @throws \Throwable
     */
    protected function apply($style, $text): string
    {
        return
            $this->enabled ? $this->color->apply($style, $text) : $text;
    }
}
