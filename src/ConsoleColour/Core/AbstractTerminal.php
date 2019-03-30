<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Core;

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

    protected const ENV_COLUMNS = 'COLUMNS';
    protected const ENV_LINES = 'LINES';
    protected const ENV_ANSICON = 'ANSICON';

    /** @var null|int */
    protected static $width;

    /** @var null|int */
    protected static $height;

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
    protected static function onWindows(): bool
    {
        return '\\' === \DIRECTORY_SEPARATOR;
    }
}
