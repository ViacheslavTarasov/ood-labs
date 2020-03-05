<?php
declare(strict_types=1);

namespace Lab07\Shape\Style;

use Lab07\Shape\RgbaColor;
use Lab07\Shape\ShapeInterface;

class GroupLineStyle implements LineStyleInterface
{

    /** @var ShapeInterface[] */
    private $shapes;

    public function __construct(array &$shapes)
    {
        $this->shapes = &$shapes;
    }

    public function isEnabled(): bool
    {
        $isEnabled = true;
        $this->styleMap(function (LineStyleInterface $style) use (&$isEnabled) {
            $isEnabled = $isEnabled && $style->isEnabled();
        });
        return $isEnabled;
    }

    public function enable(): void
    {
        $this->styleMap(function (LineStyleInterface $style) {
            $style->enable();
        });
    }

    public function disable(): void
    {
        $this->styleMap(function (LineStyleInterface $style) {
            $style->disable();
        });
    }

    public function setThickness(int $thickness): void
    {
        $this->styleMap(function (LineStyleInterface $style) use ($thickness) {
            $style->setThickness($thickness);
        });
    }

    public function getThickness(): ?int
    {
        $thickness = null;
        foreach ($this->shapes as $shape) {
            if ($shape->getLineStyle() === null) {
                return null;
            }
            $shapeThickness = $shape->getLineStyle()->getThickness();
            if ($thickness === null) {
                $thickness = $shapeThickness;
            }
            if ($thickness !== $shapeThickness) {
                return null;
            }
        }
        return $thickness;
    }

    public function setColor(RgbaColor $color): void
    {
        $this->styleMap(function (LineStyleInterface $style) use ($color) {
            $style->setColor($color);
        });
    }

    public function getColor(): ?RgbaColor
    {
        $color = null;
        foreach ($this->shapes as $shape) {
            if ($shape->getLineStyle() === null) {
                return null;
            }
            $shapeColor = $shape->getLineStyle()->getColor();
            if ($color === null) {
                $color = $shapeColor;
            }
            if ($color != $shapeColor) {
                return null;
            }
        }
        return $color;
    }

    private function styleMap(\Closure $closure): void
    {
        array_map(static function (ShapeInterface $shape) use ($closure) {
            $style = $shape->getLineStyle();
            if ($style) {
                $closure($style);
            }
        }, $this->shapes);
    }
}