<?php

namespace Lab04\Canvas;

use Lab04\Color\Color;
use Lab04\Common\Point;

class TextCanvas implements CanvasInterface
{
    /** @var \SplFileObject */
    private $outStream;

    public function __construct(\SplFileObject $outStream)
    {
        $this->outStream = $outStream;
    }

    public function setColor(Color $color): void
    {
        $text = 'set pen color: ' . $color->getR() . ' ' . $color->getG() . ' ' . $color->getB() . PHP_EOL;
        $this->outStream->fwrite($text);
    }

    public function drawLine(Point $from, Point $to): void
    {
        $text = "draw line from ({$from->getX()},{$from->getY()}) to ({$to->getX()},{$to->getY()})" . PHP_EOL;
        $this->outStream->fwrite($text);
    }

    public function drawEllipse(Point $center, int $width, int $height): void
    {
        $text = "draw ellipse: center - ({$center->getX()},{$center->getY()}), width - $width, height - $height" . PHP_EOL;
        $this->outStream->fwrite($text);
    }

}