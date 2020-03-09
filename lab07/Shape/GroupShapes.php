<?php
declare(strict_types=1);

namespace Lab07\Shape;

use Lab07\Canvas\CanvasInterface;
use Lab07\Style\FillStyleIterable;
use Lab07\Style\GroupFillStyle;
use Lab07\Style\GroupLineStyle;
use Lab07\Style\LineStyleInterface;
use Lab07\Style\LineStyleIterable;
use Lab07\Style\StyleInterface;

class GroupShapes implements GroupShapesInterface, FillStyleIterable, LineStyleIterable
{
    /** @var ShapeInterface[] */
    private $shapes = [];
    /** @var GroupFillStyle */
    private $fillStyle;
    /** @var GroupLineStyle */
    private $lineStyle;

    public function __construct()
    {
        $this->fillStyle = new GroupFillStyle($this);
        $this->lineStyle = new GroupLineStyle($this);
    }

    public function draw(CanvasInterface $canvas): void
    {
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

        if ($position < 0) {
            throw new \InvalidArgumentException('Invalid position');
        }
        array_splice($this->shapes, $position, 0, [$shape]);
    }

    public function getShapeAtIndex(int $index): ?ShapeInterface
    {
        return $this->shapes[$index] ?? null;
    }

    public function removeShapeAtIndex(int $index): void
    {
        if (!isset($this->shapes[$index])) {
            throw new \InvalidArgumentException('Invalid index');
        }
        unset($this->shapes[$index]);
    }

    public function getFrame(): ?Frame
    {
        if (!$this->shapes) {
            return null;
        }
        $minX = $minY = $maxX = $maxY = null;
        foreach ($this->shapes as $shape) {
            $frame = $shape->getFrame();
            if ($frame === null) {
                continue;
            }
            $x = $frame->getLeftTop()->getX();
            $y = $frame->getLeftTop()->getY();
            $width = $frame->getWidth();
            $height = $frame->getHeight();

            if ($minX === null || $x < $minX) {
                $minX = $x;
            }
            if ($minY === null || $y < $minY) {
                $minY = $y;
            }

            if (($x + $width) > $maxX) {
                $maxX = $x + $width;
            }

            if (($y + $height) > $maxY) {
                $maxY = $y + $height;
            }
        }

        if (null === $minX) {
            return null;
        }

        return new Frame(new Point($minX, $minY), $maxX - $minX, $maxY - $minY);
    }

    public function setFrame(Frame $frame): void
    {
        $oldFrame = $this->getFrame();
        if ($oldFrame === null) {
            return;
        }
        foreach ($this->shapes as $shape) {
            $shapeFrame = $shape->getFrame();
            if ($shapeFrame === null) {
                continue;
            }

            $leftTop = $shapeFrame->getLeftTop();
            $rightBottom = new Point($leftTop->getX() + $shapeFrame->getWidth(), $leftTop->getY() + $shapeFrame->getHeight());

            $newLeftTop = PointTransformationService::transform($leftTop, $oldFrame, $frame);
            $newRightBottom = PointTransformationService::transform($rightBottom, $oldFrame, $frame);

            $width = $newRightBottom->getX() - $newLeftTop->getX();
            $height = $newRightBottom->getY() - $newLeftTop->getY();

            $shape->setFrame(new Frame($newLeftTop, $width, $height));
        }
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
        return $this;
    }

    public function iterateFillStyle(\Closure $closure): void
    {
        array_map(static function (ShapeInterface $shape) use ($closure) {
            $style = $shape->getFillStyle();
            if ($style) {
                $closure($style);
            }
        }, $this->shapes);
    }

    public function iterateLineStyle(\Closure $closure): void
    {
        array_map(static function (ShapeInterface $shape) use ($closure) {
            $style = $shape->getLineStyle();
            if ($style) {
                $closure($style);
            }
        }, $this->shapes);
    }
}