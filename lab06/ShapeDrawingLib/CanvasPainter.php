<?php
declare(strict_types=1);

namespace Lab06\ShapeDrawingLib;

use Lab06\GraphicLib\CanvasInterface;

class CanvasPainter
{
    /** @var CanvasInterface */
    private $canvas;

    public function __construct(CanvasInterface $canvas)
    {
        $this->canvas = $canvas;
    }

    public function draw(CanvasDrawableInterface $drawable): void
    {
        $drawable->draw($this->canvas);
    }
}