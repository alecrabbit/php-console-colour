<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour;

use AlecRabbit\ConsoleColour\Contracts\DefaultStyles;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;

/**
 * @method comment(string $text)
 * @method error(string $text)
 * @method info(string $text)
 *
 * @method italic(string $text)
 * @method bold(string $text)
 * @method dark(string $text)
 * @method darkItalic(string $text)
 * @method white(string $text)
 * @method whiteBold(string $text)
 * @method yellow(string $text)
 * @method red(string $text)
 * @method green(string $text)
 * @method underlined(string $text)
 * @method underlinedBold(string $text)
 * @method underlinedItalic(string $text)
 */
class Themes implements DefaultStyles
{
    /** @var array */
    protected $definedStyles;

    /** @var bool */
    protected $doColorize = false;

    /** @var ConsoleColour */
    protected $color;

    /**
     * Themed constructor.
     * @param null|bool $colorize
     * @throws InvalidStyleException
     */
    public function __construct(?bool $colorize = null)
    {
        $this->color = new ConsoleColour();
        $this->doColorize = $this->refineColorize($colorize);
        $this->setThemes();
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
     * @throws InvalidStyleException
     */
    protected function setThemes(): void
    {
        foreach ($this->getThemes() as $name => $styles) {
            $this->color->addTheme($name, $styles);
        }
    }

    /**
     * @return array
     *
     * @psalm-suppress RedundantConditionGivenDocblockType
     */
    public function getThemes(): array
    {
        if (null !== $this->definedStyles) {
            return $this->definedStyles;
        }
        return
            $this->definedStyles = $this->prepareThemes();
    }

    /**
     * @return array
     */
    protected function prepareThemes(): array
    {
        return static::STYLES;
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
            $this->apply($this->definedStyles[$name], $arguments[0]);
    }

    /**
     * @param string $name
     */
    protected function assertMethodName(string $name): void
    {
        if (!\array_key_exists($name, $this->definedStyles)) {
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
            $this->doColorize ? $this->color->apply($style, $text) : $text;
    }
}
