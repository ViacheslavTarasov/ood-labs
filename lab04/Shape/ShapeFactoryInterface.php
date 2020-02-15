<?php
declare(strict_types=1);

namespace Lab04\Shape;

interface ShapeFactoryInterface
{
    public function createShape(string $description): Shape;
}