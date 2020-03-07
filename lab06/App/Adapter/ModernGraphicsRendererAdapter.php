<?php
declare(strict_types=1);

namespace Lab06\App\Adapter;

use Lab06\GraphicsLib\CanvasInterface;
use Lab06\ModernGraphicsLib\HexToRgbaConverter;
use Lab06\ModernGraphicsLib\ModernGraphicsRenderer;
use Lab06\ModernGraphicsLib\Point;
use Lab06\ModernGraphicsLib\RgbaColor;

class ModernGraphicsRendererAdapter implements CanvasInterface
{
    public const DEFAULT_COLOR_HEX = '#ffffff';

    /** @var ModernGraphicsRenderer */
    private $renderer;
    /** @var Point */
    private $start;
    /** @var RgbaColor */
    private $color;

    public function __construct(ModernGraphicsRenderer $modernGraphicsRenderer)
    {
        $this->start = new Point(0, 0);
        $this->renderer = $modernGraphicsRenderer;
        $this->renderer->beginDraw();
        $this->color = HexToRgbaConverter::createRgbaFromHexString(self::DEFAULT_COLOR_HEX);
    }

    public function moveTo(int $x, int $y): void
    {
        $this->start = new Point($x, $y);
    }

    public function lineTo(int $x, int $y): void
    {
        $end = new Point($x, $y);
        $this->renderer->drawLine($this->start, $end, $this->color);
        $this->start = $end;
    }

    public function setColor(string $hexColor): void
    {
        $this->color = HexToRgbaConverter::createRgbaFromHexString($hexColor);
    }
}