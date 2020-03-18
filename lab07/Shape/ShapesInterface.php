<?php
declare(strict_types=1);

namespace Lab07\Shape;

interface ShapesInterface
{
    public function getShapeCount(): int;

    public function insertShape(ShapeInterface $shape, int $position): void;

    /**
     * @param int $index
     * @return ShapeInterface
     * @throws NotFoundException
     */
    public function getShapeAtIndex(int $index): ShapeInterface;

    public function removeShapeAtIndex(int $index): void;
}