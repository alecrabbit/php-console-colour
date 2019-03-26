<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Contracts;

use JakubOnderka\PhpConsoleColor\InvalidStyleException;

interface ConsoleColorInterface extends StylesInterface
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
    public function isStyleForced(): bool;

    /**
     * @return bool
     */
    public function isSupported(): bool;

    /**
     * @return bool
     */
    public function are256ColorsSupported(): bool;

    /**
     * @param bool $forceStyle
     */
    public function setForceStyle(bool $forceStyle): void;

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
     * @param array|string $styles
     * @throws \InvalidArgumentException
     * @throws InvalidStyleException
     */
    public function addTheme($name, $styles): void;

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
