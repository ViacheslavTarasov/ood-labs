<?php
declare(strict_types=1);

namespace Lab07\Style;

use Lab07\Color\RgbaColor;

class GroupLineStyle implements LineStyleInterface
{

    /** @var LineStyleIterableInterface */
    private $lineStyleIterable;

    public function __construct(LineStyleIterableInterface $lineStyleIterable)
    {
        $this->lineStyleIterable = $lineStyleIterable;
    }

    public function isEnabled(): ?bool
    {
        $isEnabled = null;
        $first = true;
        $this->lineStyleIterable->iterateLineStyle(function (LineStyleInterface $style) use (&$isEnabled, &$first) {
            if ($first) {
                $isEnabled = $style->isEnabled();
                $first = false;
            }
            $isEnabled = $isEnabled !== $style->isEnabled() ? null : $style->isEnabled();
        });
        return $isEnabled;
    }

    public function enable(): void
    {
        $this->lineStyleIterable->iterateLineStyle(function (LineStyleInterface $style) {
            $style->enable();
        });
    }

    public function disable(): void
    {
        $this->lineStyleIterable->iterateLineStyle(function (LineStyleInterface $style) {
            $style->disable();
        });
    }

    public function setThickness(int $thickness): void
    {
        $this->lineStyleIterable->iterateLineStyle(function (LineStyleInterface $style) use ($thickness) {
            $style->setThickness($thickness);
        });
    }

    public function getThickness(): ?int
    {
        $thickness = null;
        $first = true;
        $this->lineStyleIterable->iterateLineStyle(function (LineStyleInterface $style) use (&$thickness, &$first) {
            if ($first) {
                $thickness = $style->getThickness();
                $first = false;
            }
            $thickness = $thickness !== $style->getThickness() ? null : $thickness;
        });
        return $thickness;
    }

    public function setColor(RgbaColor $color): void
    {
        $this->lineStyleIterable->iterateLineStyle(function (LineStyleInterface $style) use ($color) {
            $style->setColor($color);
        });
    }

    public function getColor(): ?RgbaColor
    {
        $color = null;
        $first = true;
        $this->lineStyleIterable->iterateLineStyle(function (StyleInterface $style) use (&$color, &$first) {
            if ($first) {
                $color = $style->getColor();
                $first = false;
            }
            $color = $color != $style->getColor() ? null : $color;
        });
        return $color;
    }
}