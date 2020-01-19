<?php
declare(strict_types=1);

namespace Lab04\Canvas;

use Lab04\Color\ColorInterface;
use Lab04\Common\Coordinates;

interface CanvasInterface
{
    public function setColor(ColorInterface $color): void;

    public function drawLine(Coordinates $from, Coordinates $to): void;

    public function drawEllipse(Coordinates $center, int $width, int $height);
}