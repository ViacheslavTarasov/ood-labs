<?php
declare(strict_types=1);

namespace Lab07\Canvas;

use Lab07\Shape\Point;
use Lab07\Shape\RgbaColor;

class TextCanvas implements CanvasInterface
{
    /** @var \SplFileObject */
    private $outStream;
    /** @var int */
    private $lineThickness = 1;
    /** @var RgbaColor */
    private $lineColor;
    /** @var RgbaColor */
    private $fillColor;

    public function __construct(\SplFileObject $outStream)
    {
        $this->outStream = $outStream;
        $this->lineColor = new RgbaColor(255, 255, 255);
        $this->fillColor = new RgbaColor(255, 255, 255);
    }

    public function reset(): void
    {
        $this->outStream->ftruncate(0);
        $text = 'reset canvas' . PHP_EOL;
        $this->outStream->fwrite($text);
    }


    public function drawLine(Point $from, Point $to): void
    {
        $text = "draw line from {$this->pointToString($from)} to {$this->pointToString($to)}"
            . ", line color - {$this->colorToString($this->lineColor)}, line thickness - {$this->lineThickness}" . PHP_EOL;
        $this->outStream->fwrite($text);
    }

    public function drawEllipse(Point $point, int $width, int $height): void
    {
        $text = "draw ellipse with center in {$this->pointToString($point)}"
            . ", line color - {$this->colorToString($this->lineColor)}, line thickness - {$this->lineThickness}" . PHP_EOL;
        $this->outStream->fwrite($text);
    }

    public function drawPolygon(array $points): void
    {
        $text = "draw polygon with vertices in {$this->pointsToString($points)}, line color - {$this->colorToString($this->lineColor)}"
            . ", line thickness - {$this->lineThickness}" . PHP_EOL;
        $this->outStream->fwrite($text);
    }

    public function drawFilledEllipse(Point $point, int $width, int $height): void
    {
        $text = "draw filled ellipse with center in {$this->pointToString($point)}, fill color - {$this->colorToString($this->fillColor)}" . PHP_EOL;
        $this->outStream->fwrite($text);
    }

    public function drawFilledPolygon(array $points): void
    {
        $text = "draw filled polygon with vertices in {$this->pointsToString($points)}, fill color - {$this->colorToString($this->fillColor)}" . PHP_EOL;
        $this->outStream->fwrite($text);
    }

    public function setFillColor(RgbaColor $color): void
    {
        $this->fillColor = $color;
        $text = "set fill color  - {$this->colorToString($this->fillColor)}" . PHP_EOL;
        $this->outStream->fwrite($text);
    }

    public function setLineColor(RgbaColor $color): void
    {
        $this->lineColor = $color;
        $text = "set line color  - {$this->colorToString($this->lineColor)}" . PHP_EOL;
        $this->outStream->fwrite($text);
    }

    public function setLineThickness(int $lineThickness): void
    {
        $this->lineThickness = $lineThickness;
        $text = "set line thickness  - {$this->lineThickness}" . PHP_EOL;
        $this->outStream->fwrite($text);
    }

    private function colorToString(RgbaColor $color): string
    {
        return "({$color->getR()}, {$color->getG()}, {$color->getB()}, {$color->getAlpha()})";
    }

    private function pointToString(Point $point): string
    {
        return "({$point->getX()}, {$point->getY()})";
    }

    private function pointsToString(array $points): string
    {
        $array = array_map(function (Point $point) {
            return $this->pointToString($point);
        }, $points);
        return implode(', ', $array);
    }
}