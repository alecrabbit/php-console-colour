<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Core\Contracts;

use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Exception\InvalidStyleException;

interface ConsoleColorInterface extends Styles
{
    /**
     * @param string|array $styles
     * @param string $text
     * @return string
     * @throws InvalidStyleException
     * @throws \InvalidArgumentException
     */
    public function apply($styles, $text): string;

    /**
     * @return bool
     */
    public function isForced(): bool;

    /**
     * @return bool
     */
    public function isApplicable(): bool;

    /**
     * @return bool
     */
    public function are256ColorsSupported(): bool;

    /**
     * @return array
     */
    public function getThemes(): array;

    /**
     * @param array $themes
     * @throws InvalidStyleException
     * @throws \InvalidArgumentException
     */
    public function setThemes(array $themes): void;

    /**
     * @param string $name
     * @param int|string|array $styles
     * @param bool $override
     * @throws \InvalidArgumentException
     * @throws InvalidStyleException
     */
    public function addTheme($name, $styles, bool $override = false): void;

    /**
     * @param string $name
     * @return bool
     */
    public function hasTheme($name): bool;

    /**
     * @param string $name
     */
    public function removeTheme($name): void;

    /**
     * @return array
     */
    public function getPossibleStyles(): array;
}
