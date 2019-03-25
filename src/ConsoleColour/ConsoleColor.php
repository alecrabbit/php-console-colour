<?php /** @noinspection UnNecessaryDoubleQuotesInspection */
declare(strict_types=1);

namespace AlecRabbit\ConsoleColour;

use JakubOnderka\PhpConsoleColor\InvalidStyleException;

class ConsoleColor
{
    public const FOREGROUND = 38;
    public const BACKGROUND = 48;
    public const RESET_STYLE = 0;
    public const COLOR256_REGEXP = '~^(bg_)?color_(\d{1,3})$~';

    protected const STYLES =
        [
            'none' => null,
            'bold' => '1',
            'dark' => '2',
            'italic' => '3',
            'underline' => '4',
            'blink' => '5',
            'reverse' => '7',
            'concealed' => '8',

            'default' => '39',
            'black' => '30',
            'red' => '31',
            'green' => '32',
            'yellow' => '33',
            'blue' => '34',
            'magenta' => '35',
            'cyan' => '36',
            'light_gray' => '37',

            'dark_gray' => '90',
            'light_red' => '91',
            'light_green' => '92',
            'light_yellow' => '93',
            'light_blue' => '94',
            'light_magenta' => '95',
            'light_cyan' => '96',
            'white' => '97',

            'bg_default' => '49',
            'bg_black' => '40',
            'bg_red' => '41',
            'bg_green' => '42',
            'bg_yellow' => '43',
            'bg_blue' => '44',
            'bg_magenta' => '45',
            'bg_cyan' => '46',
            'bg_light_gray' => '47',

            'bg_dark_gray' => '100',
            'bg_light_red' => '101',
            'bg_light_green' => '102',
            'bg_light_yellow' => '103',
            'bg_light_blue' => '104',
            'bg_light_magenta' => '105',
            'bg_light_cyan' => '106',
            'bg_white' => '107',
        ];

    /** @var bool */
    protected $isSupported;
    /** @var bool */
    protected $forceStyle = false;
    /** @var array */
    protected $themes = [];

    public function __construct()
    {
        $this->isSupported = $this->checkIfTerminalColorIsSupported();
    }

    /**
     * @return bool
     */
    public function checkIfTerminalColorIsSupported(): bool
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            if (\function_exists('sapi_windows_vt100_support') && @\sapi_windows_vt100_support(STDOUT)) {
                return true;
            } elseif (\getenv('ANSICON') !== false || \getenv('ConEmuANSI') === 'ON') {
                return true;
            }
            return false;
        } else {
            return \function_exists('posix_isatty') && @\posix_isatty(STDOUT);
        }
    }

    /**
     * @param string|array $style
     * @param string $text
     * @return string
     * @throws InvalidStyleException
     * @throws \InvalidArgumentException
     */
    public function apply($style, $text): string
    {
        if (!$this->isStyleForced() && !$this->isSupported()) {
            return $text;
        }

        if (\is_string($style)) {
            $style = [$style];
        }
        if (!\is_array($style)) {
            throw new \InvalidArgumentException("Style must be string or array.");
        }

        $sequences = [];

        foreach ($style as $s) {
            if (isset($this->themes[$s])) {
                $sequences = \array_merge($sequences, $this->themeSequence($s));
            } else {
                if ($this->isValidStyle($s)) {
                    $sequences[] = $this->styleSequence($s);
                } else {
                    throw new InvalidStyleException($s);
                }
            }
        }

        $sequences = \array_filter($sequences, function ($val) {
            return $val !== null;
        });

        if (empty($sequences)) {
            return $text;
        }

        return $this->escSequence(\implode(';', $sequences)) . $text . $this->escSequence(self::RESET_STYLE);
    }

    /**
     * @return bool
     */
    public function isStyleForced(): bool
    {
        return $this->forceStyle;
    }

    /**
     * @return bool
     */
    public function isSupported()/*: bool*/ // todo fix this
    {
        return $this->isSupported;
    }

    /**
     * @param string $name
     * @return string[]
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
     * @return string
     */
    protected function styleSequence($style)/*: string*/
    {
        if (\array_key_exists($style, static::STYLES)) {
            return static::STYLES[$style];
        }

        if (!$this->are256ColorsSupported()) {
            return null;
        }

        \preg_match(self::COLOR256_REGEXP, $style, $matches);

        $type = $matches[1] === 'bg_' ? self::BACKGROUND : self::FOREGROUND;
        $value = $matches[2];

        return "$type;5;$value";
    }

    /**
     * @return bool
     */
    public function are256ColorsSupported()
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            return \function_exists('sapi_windows_vt100_support') && @\sapi_windows_vt100_support(STDOUT);
        } else {
            return \strpos(\getenv('TERM'), '256color') !== false;
        }
    }

    /**
     * @param string $style
     * @return bool
     */
    protected function isValidStyle($style): bool
    {
        return \array_key_exists($style, static::STYLES) || \preg_match(self::COLOR256_REGEXP, $style);
    }

    /**
     * @param string|int $value
     * @return string
     */
    protected function escSequence($value): string
    {
        return "\033[{$value}m";
    }

    /**
     * @param bool $forceStyle
     */
    public function setForceStyle($forceStyle): void
    {
        $this->forceStyle = (bool)$forceStyle;
    }

    /**
     * @return array
     */
    public function getThemes(): array
    {
        return $this->themes;
    }

    /**
     * @param array $themes
     * @throws InvalidStyleException
     * @throws \InvalidArgumentException
     */
    public function setThemes(array $themes): void
    {
        $this->themes = [];
        foreach ($themes as $name => $styles) {
            $this->addTheme($name, $styles);
        }
    }

    /**
     * @param string $name
     * @param array|string $styles
     * @throws \InvalidArgumentException
     * @throws InvalidStyleException
     */
    public function addTheme($name, $styles): void
    {
        if (\is_string($styles)) {
            $styles = [$styles];
        }
        if (!\is_array($styles)) {
            throw new \InvalidArgumentException("Style must be string or array.");
        }

        foreach ($styles as $style) {
            if (!$this->isValidStyle($style)) {
                throw new InvalidStyleException($style);
            }
        }

        $this->themes[$name] = $styles;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasTheme($name): bool
    {
        return isset($this->themes[$name]);
    }

    /**
     * @param string $name
     */
    public function removeTheme($name): void
    {
        unset($this->themes[$name]);
    }

    /**
     * @return array
     */
    public function getPossibleStyles(): array
    {
        return \array_keys(static::STYLES);
    }
}
