<?php
declare(strict_types=1);

namespace Lab04\Shape;

use Lab04\Canvas\CanvasInterface;
use Lab04\Color\Color;
use Lab04\Common\Point;

class Rectangle extends Shape
{
    /** @var Point */
    private $leftTop;
    /** @var Point */
    private $rightBottom;

    public function __construct(Color $color, Point $leftTop, Point $rightBottom)
    {
        parent::__construct($color);
        $this->leftTop = $leftTop;
        $this->rightBottom = $rightBottom;
    }

    public function draw(CanvasInterface $canvas): void
    {
        $canvas->setColor($this->getColor());
        $leftTop = $this->getLeftTop();
        $rightBottom = $this->getRightBottom();
        $rightTop = new Point($rightBottom->getX(), $leftTop->getY());
        $leftBottom = new Point($leftTop->getX(), $rightBottom->getY());

        $canvas->drawLine($leftTop, $rightTop);
        $canvas->drawLine($rightTop, $rightBottom);
        $canvas->drawLine($rightBottom, $leftBottom);
        $canvas->drawLine($leftBottom, $leftTop);
    }

    public function getLeftTop(): Point
    {
        return $this->leftTop;
    }

    public function getRightBottom(): Point
    {
        return $this->rightBottom;
    }
}