<?php
declare(strict_types=1);

namespace Lab04\Shape;

use Lab04\Canvas\CanvasInterface;
use Lab04\Color\ColorInterface;

abstract class Shape implements ShapeInterface
{
    /** @var ColorInterface */
    private $color;

    public function __construct(ColorInterface $color)
    {
        $this->color = $color;
    }

    public function getColor(): ColorInterface
    {
        return $this->color;
    }

    abstract public function draw(CanvasInterface $canvas): void;
}