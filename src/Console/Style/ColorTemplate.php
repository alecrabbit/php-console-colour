<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Style;

use AlecRabbit\ConsoleColour\Contracts\Effect;

use const AlecRabbit\CSI;

final class ColorTemplate
{
    public const EFFECT_IS_NOT_ALLOWED = 'Effect "%s" is not allowed';
    public const RESET = '0';

    private function __construct()
    {
    }

    /**
     * @param mixed $f
     * @param mixed $b
     * @param array $e
     * @param int $level
     * @return string
     */
    public static function prepare($f, $b, array $e, int $level): string
    {
        $effects = [];
        foreach ($e as $effect) {
            self::assertEffect($effect);
            $effects[] = $effect;
        }
        $effects = array_unique($effects);
        if(empty($effects)) {
            return '%s';
        }
        return '%s';
    }
    /**
     * @param string $value
     * @return string
     */
    private static function escSequence(string $value): string
    {
        return
            CSI . $value . 'm';
    }

    /**
     * @param int $effect
     */
    private static function assertEffect(int $effect): void
    {
        if (!\in_array($effect, Effect::ALLOWED)) {
            throw new \InvalidArgumentException(
                sprintf(self::EFFECT_IS_NOT_ALLOWED, $effect)
            );
        }
    }

}