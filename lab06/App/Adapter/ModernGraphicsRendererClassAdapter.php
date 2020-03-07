<?php
declare(strict_types=1);

namespace Lab06\App\Adapter;

use Lab06\GraphicsLib\CanvasInterface;
use Lab06\ModernGraphicsLib\HexToRgbaConverter;
use Lab06\ModernGraphicsLib\ModernGraphicsRenderer;
use Lab06\ModernGraphicsLib\Point;
use Lab06\ModernGraphicsLib\RgbaColor;
use SplFileObject;

/** PHP doesn’t support multiple inheritance */
class ModernGraphicsRendererClassAdapter extends ModernGraphicsRenderer implements CanvasInterface
{
    public const DEFAULT_COLOR_HEX = '#ffffff';

    /** @var Point */
    private $start;
    /** @var RgbaColor */
    private $color;

    public function __construct(SplFileObject $stdout)
    {
        parent::__construct($stdout);
        $this->start = new Point(0, 0);
        $this->color = HexToRgbaConverter::createRgbaFromHexString(self::DEFAULT_COLOR_HEX);
    }

    public function moveTo(int $x, int $y): void
    {
        $this->start = new Point($x, $y);
    }

    public function lineTo(int $x, int $y): void
    {
        $end = new Point($x, $y);
        $this->drawLine($this->start, $end, $this->color);
        $this->start = $end;
    }

    public function setColor(string $hexColor): void
    {
        $this->color = HexToRgbaConverter::createRgbaFromHexString($hexColor);
    }
}