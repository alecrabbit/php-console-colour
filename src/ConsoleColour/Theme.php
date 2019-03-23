<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour;

use AlecRabbit\ConsoleColour\Contracts\DefaultThemes;
use AlecRabbit\ConsoleColour\Exception\ColorException;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;

/**
 * @method italic(string $text)
 * @method dark(string $text)
 * @method darkItalic(string $text)
 * @method white(string $text)
 * @method whiteBold(string $text)
 * @method comment(string $text)
 * @method yellow(string $text)
 * @method error(string $text)
 * @method red(string $text)
 * @method green(string $text)
 * @method info(string $text)
 * @method underline(string $text)
 * @method underlineBold(string $text)
 * @method underlineItalic(string $text)
 */
class Theme implements DefaultThemes
{
    /** @var bool */
    protected $doColorize;

    /** @var \AlecRabbit\ConsoleColour\ConsoleColour */
    protected $color;

    /**
     * Themed constructor.
     * @param bool $colorize
     * @throws InvalidStyleException
     */
    public function __construct(bool $colorize = true)
    {
        $this->doColorize = $colorize;
        $this->color = new ConsoleColour();
        $this->setThemes();
    }

    /**
     * @throws InvalidStyleException
     *
     */
    protected function setThemes(): void
    {
        foreach (static::THEMES as $name => $styles) {
            $this->color->addTheme($name, $styles);
        }
    }

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
            $this->apply(static::THEMES[$name], $arguments[0]);
    }

    /**
     * @param string $name
     */
    protected function assertMethodName(string $name): void
    {
        if (!\array_key_exists($name, static::THEMES)) {
            throw new \BadMethodCallException('Unknown method call [' . $name . '] in [' . static::class . '].');
        }
    }

    /**
     * @param string $name
     * @param array $arguments
     */
    protected function assertArgs(string $name, array $arguments): void
    {
        if (1 !== \count($arguments)) {
            throw new \ArgumentCountError('Method [' . $name . '] accepts only one argument.');
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
        try {
            return
                $this->doColorize ? $this->color->apply($style, $text) : $text;
        } catch (ColorException $e) {
            // do nothing
        }
        return $text;
    }
}
