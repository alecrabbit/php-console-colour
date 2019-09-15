<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour;

use AlecRabbit\Cli\Tools\Core\Terminal;
use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Core\Contracts\ConsoleColorInterface;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;
use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\CSI;
use const AlecRabbit\NO_COLOR_TERMINAL;
use const AlecRabbit\TRUECOLOR_TERMINAL;

class ConsoleColor implements ConsoleColorInterface
{
    /** @var bool */
    protected $supported;
    /** @var bool */
    protected $forced;
    /** @var array */
    protected $themes = [];
    /** @var int */
    protected $colorLevel;

    /**
     * ConsoleColor constructor.
     * @param null|bool|resource $stream
     * @param null|int $colorLevel
     */
    public function __construct($stream = null, ?int $colorLevel = null)
    {
        $this->colorLevel = $this->refineColorLevel($stream, $colorLevel);
    }

    /**
     * @param mixed $stream
     * @param null|int $colorLevel
     * @return int
     */
    protected function refineColorLevel($stream, ?int $colorLevel): int
    {
        $colorSupport = Terminal::colorSupport($stream);
        if (null === $colorLevel) {
            $this->supported = $colorSupport >= COLOR_TERMINAL;
            $this->forced = false;
            return $colorSupport;
        }
        $this->supported = $colorSupport >= $colorLevel;
        $this->forced = $colorSupport < $colorLevel;
        if (NO_COLOR_TERMINAL === $colorLevel) {
            $this->supported = false;
        }
        return $colorLevel;
    }

    /**
     * @return int
     */
    public function getColorLevel(): int
    {
        return $this->colorLevel;
    }

    /** {@inheritdoc} */
    public function apply($styles, $text): string
    {
        if (!$this->isApplicable()) {
            return $text;
        }

        $sequences =
            $this->getSequencesFrom(
                $this->refineStyles($styles)
            );

        if (empty($sequences)) {
            return $text;
        }

        return $this->applySequences($text, $sequences);
    }

    /** {@inheritdoc} */
    public function isApplicable(): bool
    {
        return $this->supported || $this->forced;
    }

//    /** {@inheritdoc} */
//    public function isSupported(?int $colorLevel = null): bool
//    {
//        return $this->supported || $this->forced;
//    }
//
    /**
     * @param array $styles
     * @return array
     * @throws InvalidStyleException
     */
    protected function getSequencesFrom(array $styles): array
    {
        $sequences = [[]];

        foreach ($styles as $style) {
            if (isset($this->themes[$style])) {
                $sequences[] = $this->themeSequence($style);
            } elseif ($this->isValid($style)) {
                $sequences[][] = $this->styleSequence($style);
            } else {
                throw new InvalidStyleException($style);
            }
        }

        return
            array_filter(
                array_merge(...$sequences),
                /**
                 * @param mixed $val
                 * @return bool
                 * @psalm-suppress MissingClosureParamType
                 */
                static function ($val): bool {
                    return $val !== null;
                }
            );
    }

    /**
     * @param string $name
     * @return string[]|null[]
     */
    protected function themeSequence($name): array
    {
        $sequences = [];
        foreach ($this->themes[$name] as $style) {
            $sequences[] = $this->styleSequence($style);
        }
        return $sequences;
    }

    /**
     * @param string $style
     * @return null|string
     */
    protected function styleSequence($style): ?string
    {
        if (\array_key_exists($style, static::CODES)) {
            return static::CODES[$style];
        }

        if (!$this->are256ColorsSupported()) {
            return null;
        }

        return
            $this->process256ColorStyle($style);
    }

    /** {@inheritdoc} */
    public function are256ColorsSupported(): bool
    {
        return $this->colorLevel >= COLOR256_TERMINAL;
    }

    /**
     * @param string $style
     * @return string
     */
    protected function process256ColorStyle(string $style): string
    {
        preg_match(self::COLOR256_REGEXP, $style, $matches);
        return
            sprintf(
                '%s;5;%s',
                $matches[1] === self::BG ? self::BACKGROUND : self::FOREGROUND,
                $matches[2]
            );
    }

    /**
     * @param string $style
     * @return bool
     */
    protected function isValid($style): bool
    {
        return
            \array_key_exists($style, static::CODES) || (bool)preg_match(self::COLOR256_REGEXP, $style);
    }

    /**
     * @param mixed $styles
     * @return array
     */
    protected function refineStyles($styles): array
    {
        if (\is_int($styles) || \is_string($styles)) {
            $styles = [$styles];
        }
        $this->assertStyles($styles);
        return $styles;
    }

    /**
     * @param mixed $styles
     */
    protected function assertStyles($styles): void
    {
        if (!\is_array($styles)) {
            throw new \InvalidArgumentException('Styles must be type of int, string or array.');
        }
    }

    /**
     * @param string $text
     * @param array $sequences
     * @return string
     */
    protected function applySequences(string $text, array $sequences): string
    {
        return
            $this->escSequence(implode(';', $sequences)) .
            $text .
            $this->escSequence((string)self::RESET);
    }

    /**
     * @param string $value
     * @return string
     */
    protected function escSequence(string $value): string
    {
        return
            CSI . $value . 'm';
    }

    /** {@inheritdoc} */
    public function isTrueColorSupported(): bool
    {
        return $this->colorLevel >= TRUECOLOR_TERMINAL;
    }

    /** {@inheritdoc} */
    public function isForced(): bool
    {
        return $this->forced;
    }

    /** {@inheritdoc} */
    public function getThemes(): array
    {
        return $this->themes;
    }

    /** {@inheritdoc} */
    public function setThemes(array $themes): void
    {
        $this->themes = [];
        foreach ($themes as $name => $styles) {
            $this->addTheme($name, $styles);
        }
    }

    /** {@inheritdoc} */
    public function addTheme($name, $styles, bool $override = false): void
    {
        if (\array_key_exists($name, $this->themes) && false === $override) {
            throw new \RuntimeException('Theme [' . $name . '] is already set.');
        }

        $styles = $this->refineStyles($styles);

        foreach ($styles as $style) {
            if (!$this->isValid($style)) {
                throw new InvalidStyleException($style);
            }
        }
        $this->themes[$name] = $styles;
    }

    /** {@inheritdoc} */
    public function hasTheme($name): bool
    {
        return isset($this->themes[$name]);
    }

    /** {@inheritdoc} */
    public function removeTheme($name): void
    {
        unset($this->themes[$name]);
    }

    /** {@inheritdoc} */
    public function getPossibleStyles(): array
    {
        return array_keys(Styles::NAMES);
    }

    /**
     * @return bool
     */
    public function isSupported(): bool
    {
        return $this->supported;
    }
}
