<?php declare(strict_types=1);

namespace AlecRabbit\Tests;

class Helper
{
    /**
     * @param string $str $str
     * @return mixed
     */
    public static function stripEscape(string $str)
    {
        return str_replace("\033", '\033', $str);
    }
}