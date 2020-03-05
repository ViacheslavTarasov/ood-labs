<?php
declare(strict_types=1);

namespace Lab07\Shape\Style;

use Lab07\Shape\RgbaColor;
use Lab07\Shape\ShapeInterface;

class GroupFillStyle implements StyleInterface
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
        $this->styleMap(function (StyleInterface $style) use (&$isEnabled) {
            $isEnabled = $isEnabled && $style->isEnabled();
        });
        return $isEnabled;
    }

    public function enable(): void
    {
        $this->styleMap(function (StyleInterface $style) {
            $style->enable();
        });
    }

    public function disable(): void
    {
        $this->styleMap(function (StyleInterface $style) {
            $style->disable();
        });
    }

    public function setColor(RgbaColor $color): void
    {
        $this->styleMap(function (StyleInterface $style) use ($color) {
            $style->setColor($color);
        });
    }

    public function getColor(): ?RgbaColor
    {
        $color = null;
        foreach ($this->shapes as $shape) {
            if ($shape->getFillStyle() === null) {
                return null;
            }
            $shapeColor = $shape->getFillStyle()->getColor();
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
            $style = $shape->getFillStyle();
            if ($style) {
                $closure($style);
            }
        }, $this->shapes);
    }

}