<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Style;

use AlecRabbit\Console\Color\Core\MultiColor;
use AlecRabbit\Console\Color\Core\MultiColorFactory as Factory;
use AlecRabbit\ConsoleColour\Contracts\Effect;

final class Style implements StyleInterface
{
    public const EFFECT_IS_NOT_ALLOWED = 'Effect "%s" is not allowed';

    /** @var array<int> */
    private $effects = [];
    /** @var null|MultiColor */
    private $background;
    /** @var null|MultiColor */
    private $foreground;

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
        $this->foreground =
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
        $this->background =
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

    public function render(string $string, int $terminalColor): string
    {
        return $string;
    }
}