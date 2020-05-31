<?php

declare(strict_types=1);

namespace AlecRabbit\Console\Color;

final class ClosestColor256 implements ClosestColor256Interface
{
    private $colors;

    public function __construct()
    {
        $this->colors = Core\Contracts\Tables::COLORS_8_TO_24_PARSED;
//        $this->colors = $this->parse(Core\Contracts\Tables::COLORS_8_TO_24);
    }

    private function parse(array $colors): array
    {
        $result = [];
        foreach ($colors as $color) {
            $result[] = sscanf($color, '%02x%02x%02x');
        }
        return $result;
    }

    /** @inheritDoc */
    public function hex($hex): int
    {
        return $this->rgba(...Converter::hex2rgba($hex));
    }

    /** @inheritDoc */
    public function rgba(int $r, int $g, int $b, ?int $a = null): int
    {
        $color = [$r, $g, $b];
        $this->assertRGB($color);
        $index = 0;
        $distance = 0;
        foreach ($this->colors as $i => $c) {
            $d = $this->distance($c, $color);
            if ($distance === 0 || $d < $distance) {
                $distance = $d;
                $index = $i;
            }
            if ($d === 0.0) {
                return $index;
            }
        }
        return $index;
    }

    private function assertRGB(array $array): void
    {
        foreach ($array as $i => $item) {
            if (0 > $item || $item > 255) {
                throw new \InvalidArgumentException(
                    sprintf(
                        self::WRONG_COLOR_VALUE_MESSAGE,
                        self::COLORS[$i],
                        $item
                    )
                );
            }
        }
    }

    private function distance(array $l, array $r): float
    {
        if ($l[0] === $r[0] && $l[1] === $r[1] && $l[2] === $r[2]) {
            return 0.0;
        }
        return
            sqrt(
                ($l[0] - $r[0]) ** 2 +
                ($l[1] - $r[1]) ** 2 +
                ($l[2] - $r[2]) ** 2
            );
    }

    /**
     * @param string $hex
     * @return array|int
     */
    private function hex2rgb(string $hex): array
    {
        /** @noinspection PrintfScanfArgumentsInspection */
        return sscanf($hex, '#%02x%02x%02x');
    }

}