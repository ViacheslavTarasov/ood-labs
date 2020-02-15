<?php
declare(strict_types=1);

namespace Lab04\PictureDraft;

use Lab04\Shape\Shape;

class PictureDraft
{
    private $shapes = [];

    public function addShape(Shape $shape): void
    {
        $this->shapes[] = $shape;
    }

    public function getShapeCount(): int
    {
        return count($this->shapes);
    }

    public function getShape(int $index): Shape
    {
        if (!isset($this->shapes[$index])) {
            throw new \InvalidArgumentException('invalid shape index');
        }
        return $this->shapes[$index];
    }
}