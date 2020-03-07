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
        $canvas->moveTo($this->topLeft->getX(), $this->topLeft->getY());
        $canvas->lineTo($this->bottomRight->getX(), $this->topLeft->getY());
        $canvas->lineTo($this->bottomRight->getX(), $this->bottomRight->getY());
        $canvas->lineTo($this->topLeft->getX(), $this->bottomRight->getY());
        $canvas->lineTo($this->topLeft->getX(), $this->topLeft->getY());
    }
}