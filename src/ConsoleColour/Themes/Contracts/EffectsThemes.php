<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Themes\Contracts;

use AlecRabbit\ConsoleColour\Contracts\Effect;

interface EffectsThemes
{
    public const ITALIC = 'italic';
    public const BOLD = 'bold';
    public const DARK = 'dark';
    public const CROSSED = 'crossed';
    public const UNDERLINED = 'underlined';

    public const EFFECTS = [
        self::ITALIC => Effect::ITALIC,
        self::BOLD => Effect::BOLD,
        self::DARK => Effect::DARK,
        self::UNDERLINED => [Effect::UNDERLINE],
        self::CROSSED => [Effect::CROSSED_OUT],
    ];
}
