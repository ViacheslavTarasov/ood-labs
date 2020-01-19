<?php


namespace Lab04\Shape;


use Lab04\Canvas\CanvasInterface;
use Lab04\Color\ColorInterface;

interface ShapeInterface
{
    public function getColor(): ColorInterface;

    public function draw(CanvasInterface $canvas): void;
}