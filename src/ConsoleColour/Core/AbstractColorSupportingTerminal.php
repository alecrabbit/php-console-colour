<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Core;

abstract class AbstractColorSupportingTerminal extends AbstractTerminal
{
    protected const ENV_TERM = 'TERM';
    protected const ENV_CON_EMU_ANSI = 'ConEmuANSI';
    protected const ENV_DOCKER_TERM = 'DOCKER_TERM';
    protected const COLOR_NEEDLE = '256color';
    protected const ENV_TERM_PROGRAM = 'TERM_PROGRAM';
    protected const XTERM = 'xterm';

    /** @var null|bool */
    protected static $supports256Color;

    /** @var null|bool */
    protected static $supportsColor;

    /** @var null|bool */
    protected static $isXterm;

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
            return $this->checkWindowsColorSupport();
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

        return $this->checkStream();
        // @codeCoverageIgnoreEnd
    }

    abstract public function supportsColor(bool $recheck = false): bool;

    /**
     * @return bool
     */
    protected function has256ColorSupport(): bool
    {
        return
            $this->supportsColor() ?
                $this->checkEnvVariable(static::ENV_TERM, static::COLOR_NEEDLE) ||
                $this->checkEnvVariable(static::ENV_DOCKER_TERM, static::COLOR_NEEDLE) :
                false;
    }

    /**
     * @param string $varName
     * @param string $checkFor
     * @return bool
     */
    protected function checkEnvVariable(string $varName, string $checkFor): bool
    {
        if ($t = getenv($varName)) {
            return
                false !== strpos($t, $checkFor);
        }
        return false;
    }

    /**
     * @return bool
     * @codeCoverageIgnore
     */
    protected function checkWindowsColorSupport(): bool
    {
        return (\function_exists('sapi_windows_vt100_support')
                && @sapi_windows_vt100_support(STDOUT))
            || false !== getenv(static::ENV_ANSICON)
            || 'ON' === getenv(static::ENV_CON_EMU_ANSI)
            || self::XTERM === getenv(static::ENV_TERM);
    }

    /**
     * @return bool
     * @codeCoverageIgnore
     */
    protected function checkStream(): bool
    {
        $stat = @fstat(STDOUT);
        // Check if formatted mode is S_IFCHR
        return $stat ? 0020000 === ($stat['mode'] & 0170000) : false;
    }

    /**
     * @return bool
     */
    protected function isXterm():bool
    {
        if (null !== static::$isXterm) {
            return static::$isXterm;
        }
        return
            static::$isXterm = $this->isXtermTerminal();
    }

    /**
     * @return bool
     */
    protected function isXtermTerminal():bool
    {
        return
            $this->checkEnvVariable(static::ENV_TERM, self::XTERM) ||
            $this->checkEnvVariable(static::ENV_DOCKER_TERM, self::XTERM);
    }
}
