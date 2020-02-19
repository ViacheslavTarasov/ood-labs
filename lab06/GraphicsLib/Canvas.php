<?php
declare(strict_types=1);

namespace Lab06\GraphicsLib;

class Canvas implements CanvasInterface
{
    public function moveTo(int $x, int $y): void
    {
        echo 'Move To (' . $x . ', ' . $y . ')' . PHP_EOL;
    }

    public function lineTo(int $x, int $y): void
    {
        echo 'Line To (' . $x . ', ' . $y . ')' . PHP_EOL;
    }

}