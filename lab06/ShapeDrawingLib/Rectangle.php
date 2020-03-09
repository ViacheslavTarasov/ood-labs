<?php
declare(strict_types=1);

namespace Lab06\ShapeDrawingLib;

use Lab06\GraphicsLib\CanvasInterface;

class Rectangle implements CanvasDrawableInterface
{
    /** @var Point */
    private $topLeft;
    /** @var Point */
    private $bottomRight;
    /** @var string */
    private $hexColor;

    public function __construct(Point $topLeft, int $width, int $height, string $hexColor = '#FFFFFF')
    {
        $this->topLeft = $topLeft;
        $this->bottomRight = new Point($this->topLeft->getX() + $width, $this->topLeft->getY() + $height);
        $this->hexColor = $hexColor;
    }

    public function draw(CanvasInterface $canvas): void
    {
        $canvas->setColor($this->hexColor);

        $left = $this->topLeft->getX();
        $top = $this->topLeft->getY();
        $right = $this->bottomRight->getX();
        $bottom = $this->bottomRight->getY();

        $canvas->moveTo($left, $top);
        $canvas->lineTo($right, $top);
        $canvas->lineTo($right, $bottom);
        $canvas->lineTo($left, $bottom);
        $canvas->lineTo($left, $top);
    }
}