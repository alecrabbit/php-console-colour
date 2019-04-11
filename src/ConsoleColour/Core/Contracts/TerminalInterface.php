<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Core\Contracts;

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
     * @param bool $recheck
     * @return bool
     */
    public function supports256Color(bool $recheck = false): bool;

    /**
     * @param bool $recheck
     * @return bool
     */
    public function supportsColor(bool $recheck = false): bool;

    /**
     * @param string $title
     */
    public function setTitle(string $title): void;
}
