<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Color\Core;

use AlecRabbit\Cli\Tools\Core\Terminal;

use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\NO_COLOR_TERMINAL;

final class TerminalColor
{
    /** @var bool */
    private $enabled;
    /** @var bool */
    private $forced;
    /** @var int */
    private $level;

    /**
     * TerminalColor constructor.
     * @param bool $enabled
     * @param int $level
     * @param int $supportedLevel
     */
    private function __construct(
        bool $enabled = false,
        int $level = NO_COLOR_TERMINAL,
        ?int $supportedLevel = null
    ) {
        $this->enabled = $enabled;
        $this->level = $level;
        $supportedLevel = $supportedLevel ?? $level;
        $this->forced = $level > $supportedLevel;
    }

    public static function create($stream, ?int $colorLevel): self
    {
        $colorSupport = Terminal::colorSupport($stream);
        if (null === $colorLevel) {
            return
                new self(
                    $colorSupport >= COLOR_TERMINAL,
                    $colorSupport
                );
        }

        if (NO_COLOR_TERMINAL === $colorLevel) {
            return
                new self(false);
        }

        return
            new self(
                true,
                $colorLevel,
                $colorSupport
            );
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return bool
     */
    public function isForced(): bool
    {
        return $this->forced;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }
}