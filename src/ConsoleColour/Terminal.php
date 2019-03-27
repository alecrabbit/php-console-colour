<?php declare(strict_types=1);
/*
 * This class based on
 * `Symfony\Component\Console\Terminal::class`
 * from `symfony\console` package.
 *
 * hasColorSupport() based on function
 * `Symfony\Component\Console\Output\StreamOutput::hasColorSupport()`
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */

namespace AlecRabbit\ConsoleColour;

/**
 * Class Terminal
 * @author AlecRabbit
 */
class Terminal
{
    public const DEFAULT_WIDTH = 80;
    public const DEFAULT_HEIGHT = 50;

    /** @var null|int */
    protected static $width;

    /** @var null|int */
    protected static $height;

    /** @var null|bool */
    protected static $supports256Color;

    /** @var null|bool */
    protected static $supportsColor;

    /**
     * @param bool $recheck
     * @return int
     */
    public function width(bool $recheck = false): int
    {
        if (null !== static::$width && true !== $recheck) {
            return static::$width;
        }
        return
            static::$width = $this->getWidth();
    }

    /**
     * Gets the terminal width.
     *
     * @return int
     */
    protected function getWidth(): int
    {
        $width = \getenv('COLUMNS');
        if (false !== $width) {
            return (int)\trim($width);
        }
        // @codeCoverageIgnoreStart
        if (null === static::$width) {
            static::initDimensions();
        }
        return static::$width ?: static::DEFAULT_WIDTH;
        // @codeCoverageIgnoreEnd
    }

    /**
     * @codeCoverageIgnore
     */
    protected static function initDimensions(): void
    {
        if (static::onWindows()) {
            if ((false !== $term = \getenv('ANSICON')) &&
                \preg_match('/^(\d+)x(\d+)(?: \((\d+)x(\d+)\))?$/', \trim($term), $matches)) {
                // extract [w, H] from "wxh (WxH)"
                // or [w, h] from "wxh"
                static::$width = (int)$matches[1];
                static::$height = isset($matches[4]) ? (int)$matches[4] : (int)$matches[2];
            } elseif (null !== $dimensions = static::getConsoleMode()) {
                // extract [w, h] from "wxh"
                static::$width = (int)$dimensions[0];
                static::$height = (int)$dimensions[1];
            }
        } elseif ($sttyString = static::getSttyColumns()) {
            if (\preg_match('/rows.(\d+);.columns.(\d+);/i', $sttyString, $matches)) {
                // extract [w, h] from "rows h; columns w;"
                static::$width = (int)$matches[2];
                static::$height = (int)$matches[1];
            } elseif (\preg_match('/;.(\d+).rows;.(\d+).columns/i', $sttyString, $matches)) {
                // extract [w, h] from "; h rows; w columns"
                static::$width = (int)$matches[2];
                static::$height = (int)$matches[1];
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
    protected static function getConsoleMode(): ?array
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
    protected static function getSttyColumns(): ?string
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
     * @param bool $recheck
     * @return int
     */
    public function height(bool $recheck = false): int
    {
        if (null !== static::$height && true !== $recheck) {
            return static::$height;
        }
        return
            static::$height = $this->getHeight();
    }

    /**
     * Gets the terminal height.
     *
     * @return int
     */
    protected function getHeight(): int
    {
        $height = \getenv('LINES');
        if (false !== $height) {
            return (int)\trim($height);
        }
        // @codeCoverageIgnoreStart
        if (null === static::$height) {
            static::initDimensions();
        }
        return static::$height ?: static::DEFAULT_HEIGHT;
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
        if (!$this->supportsColor()) {
            return false;
        }
        if (!$term = \getenv('TERM')) {
            // @codeCoverageIgnoreStart
            return false;
            // @codeCoverageIgnoreEnd
        }
        return \strpos($term, '256color') !== false;
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
            static::$supportsColor = $this->hasColorSupport();
    }

    /**
     * Returns true if the stream supports colorization.
     *
     * Colorization is disabled if not supported by the stream:
     *
     * This is tricky on Windows, because Cygwin, Msys2 etc emulate pseudo
     * terminals via named pipes, so we can only check the environment.
     *
     * Reference: Composer\XdebugHandler\Process::supportsColor
     * https://github.com/composer/xdebug-handler
     *
     * @return bool true if the stream supports colorization, false otherwise
     */
    protected function hasColorSupport(): bool
    {
        if ('Hyper' === \getenv('TERM_PROGRAM')) {
            return true;
        }

        if (static::onWindows()) {
            return (\function_exists('sapi_windows_vt100_support')
                    && @\sapi_windows_vt100_support(STDOUT))
                || false !== \getenv('ANSICON')
                || 'ON' === \getenv('ConEmuANSI')
                || 'xterm' === \getenv('TERM');
        }

        if (\function_exists('stream_isatty')) {
            return @\stream_isatty(STDOUT);
        }

        if (\function_exists('posix_isatty')) {
            /** @noinspection PhpComposerExtensionStubsInspection */
            return @\posix_isatty(STDOUT);
        }

        $stat = @\fstat(STDOUT);
        // Check if formatted mode is S_IFCHR
        return $stat ? 0020000 === ($stat['mode'] & 0170000) : false;
    }
}
