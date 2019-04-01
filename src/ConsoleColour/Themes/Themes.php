<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Themes;

use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use AlecRabbit\ConsoleColour\Themes\Contracts\DefaultThemes;
use AlecRabbit\ConsoleColour\Core\AbstractThemes;

/**
 * @method comment(string $text)
 * @method error(string $text)
 * @method info(string $text)
 *
 * @method yellow(string $text)
 * @method red(string $text)
 * @method green(string $text)
 * @method cyan(string $text)
 * @method magenta(string $text)

 * @method italic(string $text)
 * @method bold(string $text)
 * @method dark(string $text)
 * @method darkItalic(string $text)
 * @method white(string $text)
 * @method whiteBold(string $text)
 * @method underlined(string $text)
 * @method underlinedBold(string $text)
 * @method underlinedItalic(string $text)
 */
class Themes extends AbstractThemes implements DefaultThemes
{
    /** @var array */
    protected $definedThemes;

    /** @var bool */
    protected $doColorize = false;

    /** @var ConsoleColor */
    protected $color;

    /**
     * Themed constructor.
     * @param null|bool $colorize
     * @throws InvalidStyleException
     */
    public function __construct(?bool $colorize = null)
    {
        $this->color = new ConsoleColor();
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
    protected function prepareThemes(): array
    {
        return static::THEMES;
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
            $this->doColorize ? $this->color->apply($style, $text) : $text;
    }
}
