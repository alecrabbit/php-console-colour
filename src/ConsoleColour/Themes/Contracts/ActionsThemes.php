<?php declare(strict_types=1);


namespace AlecRabbit\ConsoleColour\Themes\Contracts;

use AlecRabbit\ConsoleColour\Contracts\BG;
use AlecRabbit\ConsoleColour\Contracts\Color;
use AlecRabbit\ConsoleColour\Contracts\Effect;

interface ActionsThemes
{
    public const DEBUG = 'debug';
    public const COMMENT = 'comment';
    public const INFO = 'info';
    public const ERROR = 'error';
    public const WARNING = 'warning';

    public const ACTIONS = [
        self::DEBUG => Effect::DARK,
        self::COMMENT => Color::YELLOW,
        self::ERROR => [Color::WHITE, Effect::BOLD, BG::RED],
        self::WARNING => [Color::LIGHT_YELLOW],
        self::INFO => Color::GREEN,
    ];
}
