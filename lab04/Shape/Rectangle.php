<?php
declare(strict_types=1);

namespace Lab04\Shape;

use Lab04\Canvas\CanvasInterface;
use Lab04\Color\ColorInterface;
use Lab04\Common\Coordinates;

class Rectangle extends Shape
{
    /** @var Coordinates */
    private $leftTop;
    /** @var Coordinates */
    private $rightBottom;

    public function __construct(ColorInterface $color, Coordinates $leftTop, Coordinates $rightBottom)
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
        $rightTop = new Coordinates($rightBottom->getX(), $leftTop->getY());
        $leftBottom = new Coordinates($leftTop->getX(), $rightBottom->getY());

        $canvas->drawLine($leftTop, $rightTop);
        $canvas->drawLine($rightTop, $rightBottom);
        $canvas->drawLine($rightBottom, $leftBottom);
        $canvas->drawLine($leftBottom, $leftTop);
    }

    public function getLeftTop(): Coordinates
    {
        return $this->leftTop;
    }

    public function getRightBottom(): Coordinates
    {
        return $this->rightBottom;
    }
}