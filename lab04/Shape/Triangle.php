<?php
declare(strict_types=1);

namespace Lab04\Shape;

use Lab04\Canvas\CanvasInterface;
use Lab04\Color\ColorInterface;
use Lab04\Common\Point;

class Triangle extends Shape
{
    /** @var Point */
    private $vertex1;
    /** @var Point */
    private $vertex2;
    /** @var Point */
    private $vertex3;

    public function __construct(ColorInterface $color, Point $vertex1, Point $vertex2, Point $vertex3)
    {
        parent::__construct($color);
        $this->vertex1 = $vertex1;
        $this->vertex2 = $vertex2;
        $this->vertex3 = $vertex3;
    }

    public function draw(CanvasInterface $canvas): void
    {
        $canvas->setColor($this->getColor());
        $canvas->drawLine($this->getVertex1(), $this->getVertex2());
        $canvas->drawLine($this->getVertex2(), $this->getVertex3());
        $canvas->drawLine($this->getVertex3(), $this->getVertex1());
    }

    public function getVertex1(): Point
    {
        return $this->vertex1;
    }

    public function getVertex2(): Point
    {
        return $this->vertex2;
    }

    public function getVertex3(): Point
    {
        return $this->vertex3;
    }
}