<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Style;

use AlecRabbit\Console\Color\Core\MultiColor;
use AlecRabbit\ConsoleColour\Contracts\Effect;

use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\CSI;
use const AlecRabbit\TRUECOLOR_TERMINAL;

final class Style implements StyleInterface
{
    public const EFFECT_IS_NOT_ALLOWED = 'Effect "%s" is not allowed';
    public const RESET = '0';

    /** @var string */
    private $truecolorTemplate;
    /** @var string */
    private $color256Template;
    /** @var string */
    private $color16Template;

    /**
     * Style constructor.
     * @param mixed $foreground
     * @param mixed $background
     * @param array<int> $effects
     */
    public function __construct($foreground, $background, array $effects)
    {
        $this->prepareTemplates($foreground, $background, $effects);
    }

    private function prepareTemplates($f, $b, array $e): void
    {
        $this->color16Template = ColorTemplate::prepare($f, $b, $e, COLOR_TERMINAL);
        $this->color256Template = ColorTemplate::prepare($f, $b, $e, COLOR256_TERMINAL);
        $this->truecolorTemplate = ColorTemplate::prepare($f, $b, $e, TRUECOLOR_TERMINAL);
    }


//    /**
//     * @param mixed $color
//     * @return self
//     */
//    private function setForegroundColor($color): self
//    {
//        $this->fgColor =
//            null === $color
//                ? null
//                : Factory::create($color);
//        return $this;
//    }
//
//    /**
//     * @param mixed $color
//     * @return self
//     */
//    private function setBackgroundColor($color): self
//    {
//        $this->bgColor =
//            null === $color
//                ? null
//                : Factory::create($color);
//        return $this;
//    }

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


    private function uniqueEffects(): void
    {
        $this->effects = array_unique($this->effects);
    }

    public function render(string $string, int $level): string
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

    public function templateFor(int $colorLevel): string
    {
        switch($colorLevel) {
            case TRUECOLOR_TERMINAL:
                return $this->truecolorTemplate;
                break;
            case COLOR256_TERMINAL:
                return $this->color256Template;
                break;
            case COLOR_TERMINAL:
                return $this->color16Template;
                break;
        }
        return '%s';
    }

}