<?php
declare(strict_types=1);

namespace Lab06\ShapeDrawingLib;

use Lab06\GraphicLib\CanvasInterface;

class Rectangle implements CanvasDrawableInterface
{
    /** @var Point */
    private $leftTop;
    /** @var int */
    private $height;
    /** @var int */
    private $width;

    public function __construct(Point $leftTop, int $width, int $height)
    {
        $this->leftTop = $leftTop;
        $this->width = $width;
        $this->height = $height;
    }

    public function draw(CanvasInterface $canvas): void
    {
        $leftTopX = $this->leftTop->getX();
        $leftTopY = $this->leftTop->getY();
        $canvas->moveTo($leftTopX, $leftTopY);
        $rightTopX = $this->leftTop->getX() + $this->width;
        $rightBottomY = $this->leftTop->getY() + $this->height;
        $canvas->lineTo($rightTopX, $leftTopY);
        $canvas->lineTo($rightTopX, $rightBottomY);
        $canvas->lineTo($leftTopX, $rightBottomY);
        $canvas->lineTo($leftTopX, $leftTopY);
    }
}