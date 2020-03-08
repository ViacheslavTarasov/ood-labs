<?php
declare(strict_types=1);

namespace Lab07\Canvas;

use Lab07\Color\RgbaColor;
use Lab07\Shape\Point;

class PngCanvas implements CanvasInterface
{
    private $image;
    /** @var RgbaColor */
    private $lineColor;
    /** @var RgbaColor */
    private $fillColor;
    /** @var int */
    private $width;
    /** @var int */
    private $height;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
        $this->reset();
    }

    public function reset(): void
    {
        $this->image = imagecreatetruecolor($this->width, $this->height);
    }

    public function drawLine(Point $from, Point $to): void
    {
        imageline(
            $this->image,
            $from->getX(),
            $from->getY(),
            $to->getX(),
            $to->getY(),
            $this->getIntLineColor()
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
            $this->getIntLineColor()
        );
    }

    public function drawFilledEllipse(Point $center, int $width, int $height): void
    {
        imagefilledellipse(
            $this->image,
            $center->getX(),
            $center->getY(),
            $width,
            $height,
            $this->getIntFillColor()
        );
    }

    public function drawPolygon(array $points): void
    {
        imagepolygon($this->image, $this->convertPointsArray($points), count($points), $this->getIntLineColor());
    }

    public function drawFilledPolygon(array $points): void
    {
        imagefilledpolygon($this->image, $this->convertPointsArray($points), count($points), $this->getIntFillColor());
    }

    public function setLineColor(RgbaColor $color): void
    {
        $this->lineColor = $color;
    }

    public function setFillColor(RgbaColor $color): void
    {
        $this->fillColor = $color;
    }

    public function setLineThickness(int $thickness): void
    {
        imagesetthickness($this->image, $thickness);
    }

    public function save(string $path): void
    {
        imagepng($this->image, $path);
    }

    private function getIntLineColor(): int
    {
        return imagecolorallocatealpha($this->image, $this->lineColor->getR(), $this->lineColor->getG(), $this->lineColor->getB(), $this->lineColor->getAlpha());
    }

    private function getIntFillColor(): int
    {
        return imagecolorallocatealpha(
            $this->image,
            $this->fillColor->getR(),
            $this->fillColor->getG(),
            $this->fillColor->getB(),
            $this->fillColor->getAlpha()
        );
    }

    /**
     * @param Point[] $points
     * @return array
     */
    private function convertPointsArray(array $points): array
    {
        $data = [];
        foreach ($points as $point) {
            $data[] = $point->getX();
            $data[] = $point->getY();
        }
        return $data;
    }
}