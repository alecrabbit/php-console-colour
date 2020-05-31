<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Console\Color;

use AlecRabbit\Console\Color\Converter;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProviderByte2Hex
     * @param string $expected
     * @param int $arg
     */
    public function convertsByte2Hex(string $expected, int $arg): void
    {
        $this->assertEquals($expected, Converter::byte2hex($arg));
    }

    /**
     * @return array[]
     */
    public function dataProviderByte2Hex(): array
    {
        return [
            ['00', 0],
            ['01', 1],
            ['02', 2],
            ['03', 3],
            ['05', 5],
            ['0a', 10],
            ['0b', 11],
            ['10', 16],
            ['ff', 256],
            ['ff', 1000],
            ['00', -234],
            ['20', 0x20],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderRgba2Hex
     * @param string $expected
     * @param array $arg
     */
    public function convertsRgba2Hex(string $expected, array $arg): void
    {
        $this->assertEquals($expected, Converter::rgba2hex(...$arg));
    }

    public function dataProviderRgba2Hex(): array
    {
        return [
            ['000000ff', [0, 0, 0]],
            ['00000000', [0, 0, 0, 0]],
            ['ffffff00', [255, 255, 255, 0]],
            ['ffffff7f', [255, 255, 255, 127]],
            ['ffffffff', [255, 255, 255, null]],
            ['ffffffff', [1255, 256, 3255, null]],
            ['00ff00ff', [0, 256, 0]],
            ['00ff000a', [0, 256, 0, 10]],
            ['000000ff', [-255, -255, -255, null]],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderHex2Rgba
     * @param array $expected
     * @param mixed $arg
     */
    public function convertsHex2Rgba(array $expected, $arg): void
    {
        $this->assertEquals($expected, Converter::hex2rgba($arg));
    }

    /**
     * @test
     */
    public function convertsHex2RgbaWithException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument 1 expected to be int|string, object given');
        $this->assertEquals('', Converter::hex2rgba(new \stdClass()));
    }

    /**
     * @test
     */
    public function normalizeHexWithException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            '[wffa] does not match one of the expected hex formats [\'#rgb\', \'#rgba\', \'#rrggbb\', \'#rrggbbaa\']'
        );
        $this->assertEquals('', Converter::normalizeHex('wffa'));
    }

    public function dataProviderHex2Rgba(): array
    {
        return [
            [[0, 0, 0, 255], '000000ff'],
            [[0, 0, 0, 0], '00000000'],
            [[255, 255, 255, 0], '#ffffff00'],
            [[255, 255, 255, 127], 'ffffff7f'],
            [[255, 255, 255, 255], '#ffffffff'],
            [[255, 255, 255, 255], 0xffffffffaaaa],
            [[255, 255, 255, 255], 'ffffff'],
            [[255, 255, 255, 255], 'fff'],
            [[255, 255, 255, 255], 'ffffff'],
            [[255, 255, 255, 255], 0xffffff],
            [[170, 170, 170, 255], '#aaa'],
            [[170, 170, 170, 170], 'aaaa'],
        ];
    }
}