<?php declare(strict_types=1);
/*
 * This class based on
 * `Symfony\Component\Console\Terminal::class`
 * from `symfony\console` package.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */

namespace Symfony;

/**
 * Class Terminal
 * @author AlecRabbit
 */
class Terminal
{
    public const DEFAULT_WIDTH = 80;
    public const DEFAULT_HEIGHT = 50;

    /** @var null|int */
    private static $width;

    /** @var null|int */
    private static $height;

    /** @var null|bool */
    private static $supports256Color;

    /** @var null|bool */
    private static $supportsColor;

    /**
     * Gets the terminal width.
     *
     * @return int
     */
    public function getWidth(): int
    {
        $width = \getenv('COLUMNS');
        if (false !== $width) {
            return (int)\trim($width);
        }
        // @codeCoverageIgnoreStart
        if (null === self::$width) {
            self::initDimensions();
        }
        return self::$width ?: static::DEFAULT_WIDTH;
        // @codeCoverageIgnoreEnd
    }

    /**
     * @codeCoverageIgnore
     */
    private static function initDimensions(): void
    {
        if (static::onWindows()) {
            if ((false !== $term = \getenv('ANSICON')) &&
                \preg_match('/^(\d+)x(\d+)(?: \((\d+)x(\d+)\))?$/', \trim($term), $matches)) {
                // extract [w, H] from "wxh (WxH)"
                // or [w, h] from "wxh"
                self::$width = (int)$matches[1];
                self::$height = isset($matches[4]) ? (int)$matches[4] : (int)$matches[2];
            } elseif (null !== $dimensions = self::getConsoleMode()) {
                // extract [w, h] from "wxh"
                self::$width = (int)$dimensions[0];
                self::$height = (int)$dimensions[1];
            }
        } elseif ($sttyString = self::getSttyColumns()) {
            if (\preg_match('/rows.(\d+);.columns.(\d+);/i', $sttyString, $matches)) {
                // extract [w, h] from "rows h; columns w;"
                self::$width = (int)$matches[2];
                self::$height = (int)$matches[1];
            } elseif (\preg_match('/;.(\d+).rows;.(\d+).columns/i', $sttyString, $matches)) {
                // extract [w, h] from "; h rows; w columns"
                self::$width = (int)$matches[2];
                self::$height = (int)$matches[1];
            }
        }
    }

    /**
     * @return bool
     */
    protected static function onWindows(): bool
    {
        return '\\' === \DIRECTORY_SEPARATOR;
    }

    /**
     * @codeCoverageIgnore
     *
     * Runs and parses mode CON if it's available, suppressing any error output.
     *
     * @return int[]|null An array composed of the width and the height or null if it could not be parsed
     */
    private static function getConsoleMode(): ?array
    {
        if (!\function_exists('proc_open')) {
            return null;
        }

        $descriptorSpec = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $process =
            \proc_open('mode CON', $descriptorSpec, $pipes, null, null, ['suppress_errors' => true]);
        if (\is_resource($process)) {
            $info = \stream_get_contents($pipes[1]);
            \fclose($pipes[1]);
            \fclose($pipes[2]);
            \proc_close($process);

            if (false !== $info && \preg_match('/--------+\r?\n.+?(\d+)\r?\n.+?(\d+)\r?\n/', $info, $matches)) {
                return [(int)$matches[2], (int)$matches[1]];
            }
        }
        return null;
    }

    /**
     * @codeCoverageIgnore
     *
     * Runs and parses stty -a if it's available, suppressing any error output.
     *
     * @return string|null
     */
    private static function getSttyColumns(): ?string
    {
        if (!\function_exists('proc_open')) {
            return null;
        }

        $descriptorSpec = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $process = \proc_open(
            'stty -a | grep columns',
            $descriptorSpec,
            $pipes,
            null,
            null,
            ['suppress_errors' => true]
        );

        if (\is_resource($process)) {
            $info = \stream_get_contents($pipes[1]);
            \fclose($pipes[1]);
            \fclose($pipes[2]);
            \proc_close($process);

            return $info ?: null;
        }
        return null;
    }

    /**
     * Gets the terminal height.
     *
     * @return int
     */
    public function getHeight(): int
    {
        $height = \getenv('LINES');
        if (false !== $height) {
            return (int)\trim($height);
        }
        // @codeCoverageIgnoreStart
        if (null === self::$height) {
            self::initDimensions();
        }
        return self::$height ?: static::DEFAULT_HEIGHT;
        // @codeCoverageIgnoreEnd
    }

    /**
     * @return bool
     */
    public function supports256Color(): bool
    {
        if (null !== static::$supports256Color) {
            return static::$supports256Color;
        }
        return
            static::$supports256Color = $this->check256ColorSupport();
    }

    /**
     * @return bool
     */
    protected function check256ColorSupport(): bool
    {
        if (static::onWindows()) {
            return
                \function_exists('sapi_windows_vt100_support') && @\sapi_windows_vt100_support(STDOUT);
        }
        if (!$terminal = \getenv('TERM')) {
            // @codeCoverageIgnoreStart
            return false;
            // @codeCoverageIgnoreEnd
        }
        return \strpos($terminal, '256color') !== false;
    }

    /**
     * @return bool
     */
    public function supportsColor(): bool
    {
        if (null !== static::$supportsColor) {
            return static::$supportsColor;
        }
        return
            static::$supportsColor = $this->checkColorSupport();
    }

    /**
     * @return bool
     */
    protected function checkColorSupport(): bool
    {
        if (static::onWindows()) {
            if (\function_exists('sapi_windows_vt100_support') && @\sapi_windows_vt100_support(STDOUT)) {
                return true;
            }
            if (\getenv('ANSICON') !== false || \getenv('ConEmuANSI') === 'ON') {
                return true;
            }
            return false;
        }
        /** @noinspection PhpComposerExtensionStubsInspection */
        return \function_exists('posix_isatty') && @\posix_isatty(STDOUT);
    }
}
