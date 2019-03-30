<?php declare(strict_types=1);

namespace AlecRabbit\ConsoleColour\Exception;

class InvalidStyleException extends \Exception
{
    /**
     * InvalidStyleException constructor.
     * @param string $styleName
     */
    public function __construct(string $styleName)
    {
        parent::__construct("Style '$styleName' is not allowed.");
    }
}
