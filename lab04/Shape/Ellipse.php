<?php
declare(strict_types=1);

namespace Lab04\Shape;

use Lab04\Canvas\CanvasInterface;
use Lab04\Color\ColorInterface;
use Lab04\Common\Point;

class Ellipse extends Shape
{
    /** @var Point */
    private $center;
    /** @var int */
    private $width;
    /** @var int */
    private $height;

    public function __construct(ColorInterface $color, Point $center, int $width, int $height)
    {
        parent::__construct($color);
        $this->center = $center;
        $this->width = $width;
        $this->height = $height;
    }

    public function draw(CanvasInterface $canvas): void
    {
        $canvas->setColor($this->getColor());
        $canvas->drawEllipse($this->getCenter(), $this->getWidth(), $this->getHeight());
    }

    public function getCenter(): Point
    {
        return $this->center;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }
}