<?php
declare(strict_types=1);

namespace Lab04\Shape;

use Lab04\Canvas\CanvasInterface;
use Lab04\Color\Color;

abstract class Shape
{
    /** @var Color */
    private $color;

    public function __construct(Color $color)
    {
        $this->color = $color;
    }

    public function getColor(): Color
    {
        return $this->color;
    }

    abstract public function draw(CanvasInterface $canvas): void;
}