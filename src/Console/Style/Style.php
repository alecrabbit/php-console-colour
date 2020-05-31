<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Style;

use AlecRabbit\Console\Color\Core\MultiColor;
use AlecRabbit\Console\Color\Core\MultiColorFactory as Factory;
use AlecRabbit\Console\Color\Core\TerminalColor;
use AlecRabbit\ConsoleColour\Contracts\Effect;

use const AlecRabbit\CSI;

final class Style implements StyleInterface
{
    public const EFFECT_IS_NOT_ALLOWED = 'Effect "%s" is not allowed';
    public const RESET = '0';

    /** @var array<int> */
    private $effects = [];
    /** @var null|MultiColor */
    private $bgColor;
    /** @var null|MultiColor */
    private $fgColor;

    /**
     * Style constructor.
     * @param mixed $foreground
     * @param mixed $background
     * @param array<int> $effects
     */
    public function __construct($foreground, $background, array $effects)
    {
        $this->setForegroundColor($foreground);
        $this->setBackgroundColor($background);
        $this->setEffects($effects);
    }

    /**
     * @param mixed $color
     * @return self
     */
    private function setForegroundColor($color): self
    {
        $this->fgColor =
            null === $color
                ? null
                : Factory::create($color);
        return $this;
    }

    /**
     * @param mixed $color
     * @return self
     */
    private function setBackgroundColor($color): self
    {
        $this->bgColor =
            null === $color
                ? null
                : Factory::create($color);
        return $this;
    }

    /**
     * @param array<int> $effects
     * @return $this
     */
    private function setEffects(array $effects): self
    {
        foreach ($effects as $effect) {
            $this->storeEffect($effect);
        }
        $this->uniqueEffects();
        return $this;
    }

    /**
     * @param int $effect
     */
    private function storeEffect(int $effect): void
    {
        $this->assertEffect($effect);
        $this->effects[] = $effect;
    }

    /**
     * @param int $effect
     */
    private function assertEffect(int $effect): void
    {
        if (!\in_array($effect, Effect::ALLOWED)) {
            throw new \InvalidArgumentException(
                sprintf(self::EFFECT_IS_NOT_ALLOWED, $effect)
            );
        }
    }

    private function uniqueEffects(): void
    {
        $this->effects = array_unique($this->effects);
    }

    public function render(string $string, TerminalColor $terminalColor): string
    {
        $effects = $this->escSequence(implode(';', $this->effects));
        $bgColor =
            $this->escSequence(
                implode(
                    ';',
                    $this->bgColor instanceof MultiColor
                        ? $this->bgColor->getSequence($terminalColor)
                        : []
                )
            );
        $fgColor =
            $this->escSequence(
                implode(
                    ';',
                    $this->fgColor instanceof MultiColor
                        ? $this->fgColor->getSequence($terminalColor)
                        : []
                )
            );
        return
            $effects
            . $bgColor
            . $fgColor
            . $string
            . $this->escSequence(self::RESET);
    }

    /**
     * @param string $value
     * @return string
     */
    protected function escSequence(string $value): string
    {
        return
            CSI . $value . 'm';
    }

}