<?php
declare(strict_types=1);

namespace Lab06\GraphicLib;

interface CanvasInterface
{
    public function moveTo(int $x, int $y): void;

    public function lineTo(int $x, int $y): void;
}