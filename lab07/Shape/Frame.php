<?php
declare(strict_types=1);

namespace Lab07\Shape;

class Frame
{
    /** @var Point */
    private $leftTop;
    /** @var int */
    private $width;
    /** @var int */
    private $height;

    public function __construct(Point $leftTop, int $width, int $height)
    {
        $this->leftTop = $leftTop;
        $this->width = $width;
        $this->height = $height;
    }

    public function getLeftTop(): Point
    {
        return $this->leftTop;
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