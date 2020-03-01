<?php
declare(strict_types=1);

namespace Lab07\Shape;

use Lab07\Canvas\CanvasDrawableInterface;
use Lab07\Shape\Style\FillStyle;
use Lab07\Shape\Style\LineStyleInterface;

interface ShapeInterface extends CanvasDrawableInterface
{
    public function getFrame(): ?Frame;

    public function setFrame(Frame $frame): void;

    public function getLineStyle(): ?LineStyleInterface;

    public function setLineStyle(LineStyleInterface $style): void;

    public function getFillStyle(): ?FillStyle;

    public function setFillStyle(FillStyle $style): void;

    public function getGroup(): ?GroupShapesInterface;
}