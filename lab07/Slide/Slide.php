<?php
declare(strict_types=1);

namespace Lab07\Slide;

use Lab07\Canvas\CanvasDrawableInterface;
use Lab07\Canvas\CanvasInterface;
use Lab07\Shape\NotFoundException;
use Lab07\Shape\ShapeInterface;
use Lab07\Shape\ShapesInterface;

class Slide implements CanvasDrawableInterface, ShapesInterface
{
    /**
     * @var ShapeInterface[]
     */
    private $shapes = [];
    /** @var int */
    private $width;
    /** @var int */
    private $height;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function draw(CanvasInterface $canvas): void
    {
        $canvas->reset();
        foreach ($this->shapes as $shape) {
            $shape->draw($canvas);
        }
    }

    public function getShapeCount(): int
    {
        return count($this->shapes);
    }

    public function insertShape(ShapeInterface $shape, int $position): void
    {
        if ($position > $this->getShapeCount()) {
            throw new \InvalidArgumentException('Invalid position');
        }
        array_splice($this->shapes, $position, 0, [$shape]);
    }

    /**
     * @param int $index
     * @return ShapeInterface
     * @throws NotFoundException
     */
    public function getShapeAtIndex(int $index): ShapeInterface
    {
        $this->checkShapeIssetOrException($index);
        return $this->shapes[$index] ?? null;
    }

    /**
     * @param int $index
     * @throws NotFoundException
     */
    public function removeShapeAtIndex(int $index): void
    {
        $this->checkShapeIssetOrException($index);
        array_splice($this->shapes, $index, 1);
    }

    /**
     * @param int $index
     * @throws NotFoundException
     */
    private function checkShapeIssetOrException(int $index): void
    {
        if (!isset($this->shapes[$index])) {
            throw new NotFoundException('Shape not found');
        }
    }
}