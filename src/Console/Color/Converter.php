<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Color;

final class Converter
{
    public const REGEXP = "/^((?:[\da-f]{3}){1,2}|(?:[\da-f]{4}){1,2})$/i";
    public const DOES_NOT_MATCH_EXPECTED_FORMATS = '[%s] does not match one of the expected hex formats [\'%s\']';
    public const EXPECTED_FORMATS = ['#rgb', '#rgba', '#rrggbb', '#rrggbbaa',];

    public static function rgba2hex(int $r, int $g, int $b, ?int $a = null): string
    {
        $hex = '';
        $c = [$r, $g, $b, $a ?? 0xff];
        foreach ($c as $value) {
            $hex .= self::byte2hex($value);
        }
        return $hex;
    }

    /**
     * @param int $byte
     * @return string
     */
    public static function byte2hex(int $byte): string
    {
        if (0 > $byte) {
            $byte = 0;
        }
        if (255 < $byte) {
            $byte = 255;
        }
        $hex = dechex($byte);
        if (1 === \strlen($hex)) {
            $hex = '0' . $hex;
        }
        return $hex;
    }

    /**
     * @param int|string $hex
     * @return array<int>
     */
    public static function hex2rgba($hex): array
    {
        $hex = self:: normalizeHex($hex);
        /** @noinspection PrintfScanfArgumentsInspection */
        return sscanf($hex, '#%02x%02x%02x%02x');
    }

    /**
     * @param int|string $hex
     * @return string
     */
    public static function normalizeHex($hex): string
    {
        $hex = self::int2hex($hex);
        $hex = ltrim(rtrim(ltrim($hex)), '#');
        if (8 < \strlen($hex)) {
            $hex = substr($hex, 0, 8);
        }
        self::assertHex($hex);
        if (6 === \strlen($hex)) {
            $hex .= 'ff';
        }
        if (3 === \strlen($hex)) {
            $hex .= 'f';
        }
        if (4 === \strlen($hex)) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2] . $hex[3] . $hex[3];
        }
        return '#' . $hex;
    }

    /**
     * @param int|string $hex
     * @return string
     */
    private static function int2hex($hex): string
    {
        if (\is_int($hex)) {
            return dechex((int)(string)$hex);
        }
        if (!\is_string($hex)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Argument 1 expected to be int|string, %s given',
                    \gettype($hex)
                )
            );
        }
        return $hex;
    }

    private static function assertHex(string $hex): void
    {
        if (!(bool)preg_match(self::REGEXP, $hex)) {
            throw new \InvalidArgumentException(
                sprintf(
                    self::DOES_NOT_MATCH_EXPECTED_FORMATS,
                    $hex,
                    implode('\', \'', self::EXPECTED_FORMATS)
                )
            );
        }
    }

}