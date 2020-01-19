<?php
declare(strict_types=1);

namespace Lab04\PictureDraft;

use Lab04\Shape\ShapeInterface;

class PictureDraft
{
    private $shapes = [];

    public function addShape(ShapeInterface $shape): void
    {
        $this->shapes[] = $shape;
    }

    public function getShapeCount(): int
    {
        return count($this->shapes);
    }

    public function getShape(int $index): ShapeInterface
    {
        if (!isset($this->shapes[$index])) {
            throw new \InvalidArgumentException('invalid shape index');
        }
        return $this->shapes[$index];
    }
}