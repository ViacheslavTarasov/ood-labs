<?php
declare(strict_types=1);

namespace Lab04\Canvas;

use Lab04\Color\Color;
use Lab04\Common\Point;

class PngCanvas implements CanvasInterface
{
    /** @var Color */
    private $color;
    private $image;

    public function __construct(int $width, int $height)
    {
        $this->image = imagecreatetruecolor($width, $height);
    }

    public function setColor(Color $color): void
    {
        $this->color = $color;
    }

    public function drawLine(Point $from, Point $to): void
    {
        imageline(
            $this->image,
            $from->getX(),
            $from->getY(),
            $to->getX(),
            $to->getY(),
            $this->getIntColor()
        );
    }

    public function drawEllipse(Point $center, int $width, int $height): void
    {
        imageellipse(
            $this->image,
            $center->getX(),
            $center->getY(),
            $width,
            $height,
            $this->getIntColor()
        );
    }

    public function save(string $path): void
    {
        imagepng($this->image, $path);
    }


    private function getIntColor(): int
    {
        return imagecolorallocate($this->image, $this->color->getR(), $this->color->getG(), $this->color->getB());
    }

}