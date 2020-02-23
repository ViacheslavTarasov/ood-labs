<?php
declare(strict_types=1);

namespace Lab07\Canvas;

use Lab07\Common\Point;
use Lab07\Common\RgbaColor;

interface CanvasInterface
{
    public function drawLine(Point $from, Point $to): void;

    public function drawEllipse(Point $center, int $width, int $height): void;

    public function drawFilledEllipse(Point $center, int $width, int $height): void;

    /**
     * @param Point[] $points
     */
    public function drawPolygon(array $points): void;

    /**
     * @param Point[] $points
     */
    public function drawFilledPolygon(array $points): void;

    public function setLineColor(RgbaColor $color): void;

    public function setFillColor(RgbaColor $color): void;

    public function setLineThickness(int $thickness): void;

    public function reset(): void;

}