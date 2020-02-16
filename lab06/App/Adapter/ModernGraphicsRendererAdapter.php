<?php
declare(strict_types=1);

namespace Lab06\App\Adapter;

use Lab06\GraphicLib\CanvasInterface;
use Lab06\ModernGraphicsLib\ModernGraphicsRenderer;
use Lab06\ModernGraphicsLib\Point;

class ModernGraphicsRendererAdapter implements CanvasInterface
{
    /** @var ModernGraphicsRenderer */
    private $renderer;
    /** @var Point */
    private $start;

    public function __construct($modernGraphicsRenderer)
    {
        $this->renderer = $modernGraphicsRenderer;
        $this->renderer->beginDraw();
    }

    public function moveTo(int $x, int $y): void
    {
        $this->start = new Point($x, $y);
    }

    public function lineTo(int $x, int $y): void
    {
        $end = new Point($x, $y);
        $this->renderer->drawLine($this->start, $end);
        $this->start = $end;
    }


}