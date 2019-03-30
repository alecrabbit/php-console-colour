<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour;

/**
 * Class Terminal
 *
 * Reference: Symfony\Component\Console\Terminal::class
 * https://github.com/symfony/console
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @author AlecRabbit
 */
abstract class AbstractTerminal
{
    protected const DEFAULT_WIDTH = 80;
    protected const DEFAULT_HEIGHT = 50;
    protected const ENV_TERM = 'TERM';
    protected const ENV_ANSICON = 'ANSICON';
    protected const ENV_CON_EMU_ANSI = 'ConEmuANSI';
    protected const ENV_DOCKER_TERM = 'DOCKER_TERM';
    protected const COLOR_NEEDLE = '256color';
    protected const ENV_COLUMNS = 'COLUMNS';
    protected const ENV_LINES = 'LINES';
    protected const ENV_TERM_PROGRAM = 'TERM_PROGRAM';

    /** @var null|int */
    protected static $width;

    /** @var null|int */
    protected static $height;

    /** @var null|bool */
    protected static $supports256Color;

    /** @var null|bool */
    protected static $supportsColor;

    /**
     * @codeCoverageIgnore
     */
    protected static function initDimensions(): void
    {
        if (static::onWindows()) {
            self::initDimensionsWindows();
        } elseif ($sttyString = static::getSttyColumns()) {
            self::initDimensionsUnix($sttyString);
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
     */
    protected static function initDimensionsWindows(): void
    {
        if ((false !== $term = getenv(static::ENV_ANSICON)) &&
            preg_match('/^(\d+)x(\d+)(?: \((\d+)x(\d+)\))?$/', trim($term), $matches)) {
            // extract [w, H] from "wxh (WxH)"
            // or [w, h] from "wxh"
            static::$width = (int)$matches[1];
            static::$height = isset($matches[4]) ? (int)$matches[4] : (int)$matches[2];
        } elseif (null !== $dimensions = static::getConsoleMode()) {
            // extract [w, h] from "wxh"
            static::$width = (int)$dimensions[0];
            static::$height = (int)$dimensions[1];
        }
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
            proc_open('mode CON', $descriptorSpec, $pipes, null, null, ['suppress_errors' => true]);
        if (\is_resource($process)) {
            $info = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);

            if (false !== $info && preg_match('/--------+\r?\n.+?(\d+)\r?\n.+?(\d+)\r?\n/', $info, $matches)) {
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

        $process = proc_open(
            'stty -a | grep columns',
            $descriptorSpec,
            $pipes,
            null,
            null,
            ['suppress_errors' => true]
        );

        if (\is_resource($process)) {
            $info = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);

            return $info ?: null;
        }
        return null;
    }

    /**
     * @codeCoverageIgnore
     * @param string $sttyString
     */
    protected static function initDimensionsUnix(string $sttyString): void
    {
        if (preg_match('/rows.(\d+);.columns.(\d+);/i', $sttyString, $matches)) {
            // extract [w, h] from "rows h; columns w;"
            static::$width = (int)$matches[2];
            static::$height = (int)$matches[1];
        } elseif (preg_match('/;.(\d+).rows;.(\d+).columns/i', $sttyString, $matches)) {
            // extract [w, h] from "; h rows; w columns"
            static::$width = (int)$matches[2];
            static::$height = (int)$matches[1];
        }
    }

    abstract public function supportsColor(bool $recheck = false): bool;

    /**
     * Gets the terminal width.
     *
     * @return int
     */
    protected function getWidth(): int
    {
        $width = getenv(static::ENV_COLUMNS);
        if (false !== $width) {
            return (int)trim($width);
        }
        // @codeCoverageIgnoreStart
        if (null === static::$width) {
            static::initDimensions();
        }
        return static::$width ?: static::DEFAULT_WIDTH;
        // @codeCoverageIgnoreEnd
    }

    /**
     * Gets the terminal height.
     *
     * @return int
     */
    protected function getHeight(): int
    {
        $height = getenv(static::ENV_LINES);
        if (false !== $height) {
            return (int)trim($height);
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
    protected function check256ColorSupport(): bool
    {
        return
            $this->supportsColor() ?
                $this->checkFor256ColorSupport(static::ENV_TERM) ||
                $this->checkFor256ColorSupport(static::ENV_DOCKER_TERM) :
                false;
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
     * Reference: Symfony\Component\Console\Output\StreamOutput::hasColorSupport()
     * https://github.com/symfony/console
     *
     * @return bool true if the stream supports colorization, false otherwise
     */
    protected function hasColorSupport(): bool
    {
        if ('Hyper' === getenv(static::ENV_TERM_PROGRAM)) {
            // @codeCoverageIgnoreStart
            return true;
            // @codeCoverageIgnoreEnd
        }

        // @codeCoverageIgnoreStart
        if (static::onWindows()) {
            return (\function_exists('sapi_windows_vt100_support')
                    && @sapi_windows_vt100_support(STDOUT))
                || false !== getenv(static::ENV_ANSICON)
                || 'ON' === getenv(static::ENV_CON_EMU_ANSI)
                || 'xterm' === getenv(static::ENV_TERM);
        }
        // @codeCoverageIgnoreEnd

        if (\function_exists('stream_isatty')) {
            return @stream_isatty(STDOUT);
        }

        // @codeCoverageIgnoreStart
        if (\function_exists('posix_isatty')) {
            /** @noinspection PhpComposerExtensionStubsInspection */
            return @posix_isatty(STDOUT);
        }

        $stat = @fstat(STDOUT);
        // Check if formatted mode is S_IFCHR
        return $stat ? 0020000 === ($stat['mode'] & 0170000) : false;
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param string $varName
     * @return bool
     */
    protected function checkFor256ColorSupport(string $varName): bool
    {
        if ($t = getenv($varName)) {
            return
                false !== strpos($t, static::COLOR_NEEDLE);
        }
        return false;
    }
}
