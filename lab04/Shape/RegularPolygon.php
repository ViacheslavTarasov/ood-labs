<?php

namespace Lab04\Shape;

use Lab04\Canvas\CanvasInterface;
use Lab04\Color\ColorInterface;
use Lab04\Common\Coordinates;

class RegularPolygon extends Shape
{
    /** @var Coordinates */
    private $center;
    /** @var int */
    private $vertexCount;
    /** @var int */
    private $radius;

    private const MIN_VERTEX_COUNT = 3;

    public function __construct(ColorInterface $color, Coordinates $center, int $vertexCount, int $radius)
    {
        parent::__construct($color);
        if ($vertexCount < self::MIN_VERTEX_COUNT) {
            throw new \InvalidArgumentException('Invalid vertex count');
        }
        $this->center = $center;
        $this->vertexCount = $vertexCount;
        $this->radius = $radius;
    }

    public function draw(CanvasInterface $canvas): void
    {
        $canvas->setColor($this->getColor());
        $prev = $this->getVertexCoordinates(0);
        for ($i = 1; $i <= $this->vertexCount; $i++) {
            $current = $this->getVertexCoordinates($i);
            $canvas->drawLine($prev, $current);
            $prev = $current;
        }
    }

    private function getVertexCoordinates(int $number): Coordinates
    {
        $angle = 360 / $this->vertexCount;
        $nextAngleInRad = deg2rad($angle * $number - 90);
        $x = round($this->center->getX() + $this->radius * cos($nextAngleInRad));
        $y = round($this->center->getY() + $this->radius * sin($nextAngleInRad));
        return new Coordinates($x, $y);
    }

    public function getCenter(): Coordinates
    {
        return $this->center;
    }

    public function getVertexCount(): int
    {
        return $this->vertexCount;
    }

    public function getRadius(): int
    {
        return $this->radius;
    }
}