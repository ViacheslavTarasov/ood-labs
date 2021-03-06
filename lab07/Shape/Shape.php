<?php
declare(strict_types=1);

namespace Lab07\Shape;

use Lab07\Style\LineStyleInterface;
use Lab07\Style\StyleInterface;

abstract class Shape implements ShapeInterface
{
    /** @var LineStyleInterface */
    private $lineStyle;
    /** @var StyleInterface */
    private $fillStyle;

    public function __construct(LineStyleInterface $lineStyle, StyleInterface $fillStyle)
    {
        $this->lineStyle = $lineStyle;
        $this->fillStyle = $fillStyle;
    }

    public function getLineStyle(): LineStyleInterface
    {
        return $this->lineStyle;
    }

    public function getFillStyle(): StyleInterface
    {
        return $this->fillStyle;
    }

    public function getGroup(): ?GroupShapesInterface
    {
        return null;
    }
}