<?php
declare(strict_types=1);

namespace Lab06\ShapeDrawingLib;

use Lab06\GraphicsLib\CanvasInterface;

interface CanvasDrawableInterface
{
    public function draw(CanvasInterface $canvas): void;
}