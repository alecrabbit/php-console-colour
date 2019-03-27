<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Contracts;

/**
 * Interface TerminalInterface
 *
 * @author AlecRabbit
 */
interface TerminalInterface
{
    /**
     * @param bool $recheck
     * @return int
     */
    public function width(bool $recheck = false): int;

    /**
     * @param bool $recheck
     * @return int
     */
    public function height(bool $recheck = false): int;

    /**
     * @return bool
     */
    public function supports256Color(): bool;

    /**
     * @return bool
     */
    public function supportsColor(): bool;
}
