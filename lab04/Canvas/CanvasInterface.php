<?php
declare(strict_types=1);

namespace Lab04\Canvas;

use Lab04\Color\Color;
use Lab04\Common\Point;

interface CanvasInterface
{
    public function setColor(Color $color): void;

    public function drawLine(Point $from, Point $to): void;

    public function drawEllipse(Point $center, int $width, int $height): void;
}