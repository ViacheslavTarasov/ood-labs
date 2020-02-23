<?php
declare(strict_types=1);

namespace Lab07\Canvas;

interface CanvasDrawableInterface
{
    public function draw(CanvasInterface $canvas): void;
}