<?php
declare(strict_types=1);

namespace Lab07\Shape;

use Lab07\Canvas\CanvasDrawableInterface;
use Lab07\Shape\Style\LineStyleInterface;
use Lab07\Shape\Style\StyleInterface;

interface ShapeInterface extends CanvasDrawableInterface
{
    public function getFrame(): ?Frame;

    public function setFrame(Frame $frame): void;

    public function getLineStyle(): LineStyleInterface;

    public function getFillStyle(): StyleInterface;

    public function getGroup(): ?GroupShapesInterface;
}