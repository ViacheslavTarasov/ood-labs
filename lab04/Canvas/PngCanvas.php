<?php
declare(strict_types=1);

namespace Lab04\Canvas;

use Lab04\Color\ColorInterface;
use Lab04\Common\Coordinates;

class PngCanvas implements CanvasInterface
{
    /** @var ColorInterface */
    private $color;
    private $image;
    private $path;

    public function __construct(int $width, int $height, string $path)
    {
        $this->image = imagecreatetruecolor($width, $height);
        $this->path = $path;
    }

    public function setColor(ColorInterface $color): void
    {
        $this->color = $color;
    }

    public function drawLine(Coordinates $from, Coordinates $to): void
    {
        imageline(
            $this->image,
            $from->getX(),
            $from->getY(),
            $to->getX(),
            $to->getY(),
            $this->getIntColor()
        );
        imagepng($this->image, $this->path);
    }

    public function drawEllipse(Coordinates $center, int $width, int $height): void
    {
        imageellipse(
            $this->image,
            $center->getX(),
            $center->getY(),
            $width,
            $height,
            $this->getIntColor()
        );
        imagepng($this->image, $this->path);
    }


    private function getIntColor(): int
    {
        return imagecolorallocate($this->image, $this->color->getR(), $this->color->getG(), $this->color->getB());
    }

}