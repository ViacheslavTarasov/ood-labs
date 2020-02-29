<?php
declare(strict_types=1);

namespace Lab06\ModernGraphicsLib;

class HexToRgbaConverter
{
    public function createRgbaFromHexString(string $hexColor): RgbaColor
    {
        $hexColor = preg_replace('/[^0-9A-Fa-f]/', '', $hexColor);
        $colorParts = str_split($hexColor, 2);

        $r = $this->hexToRgbaColorFloat($colorParts[0] ?? '');
        $g = $this->hexToRgbaColorFloat($colorParts[1] ?? '');
        $b = $this->hexToRgbaColorFloat($colorParts[2] ?? '');
        $alpha = 1;

        return new RgbaColor($r, $g, $b, $alpha);
    }

    private function hexToRgbaColorFloat(string $hex): float
    {
        return round(hexdec($hex ?? '') / 255, 2);
    }
}