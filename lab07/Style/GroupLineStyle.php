<?php
declare(strict_types=1);

namespace Lab07\Style;

use Lab07\Color\RgbaColor;

class GroupLineStyle implements LineStyleInterface
{

    /** @var LineStyleIterable */
    private $lineStyleIterable;

    public function __construct(LineStyleIterable $lineStyleIterable)
    {
        $this->lineStyleIterable = $lineStyleIterable;
    }

    public function isEnabled(): bool
    {
        $isEnabled = true;
        $this->lineStyleIterable->iterateLineStyle(function (LineStyleInterface $style) use (&$isEnabled) {
            $isEnabled = $isEnabled && $style->isEnabled();
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
        $ready = false;
        $this->lineStyleIterable->iterateLineStyle(function (LineStyleInterface $style) use (&$thickness, &$ready) {
            if ($ready) {
                return;
            }
            if ($style->getThickness() === null) {
                $ready = true;
                $thickness = null;
            }
            if ($thickness === null) {
                $thickness = $style->getThickness();
            }
            if ($thickness != $style->getThickness()) {
                $ready = true;
                $thickness = null;
            }

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
        $ready = false;
        $this->lineStyleIterable->iterateLineStyle(function (StyleInterface $style) use (&$color, &$ready) {
            if ($ready) {
                return;
            }
            if ($style->getColor() === null) {
                $ready = true;
                $color = null;
            }
            if ($color === null) {
                $color = $style->getColor();
            }
            if ($color != $style->getColor()) {
                $ready = true;
                $color = null;
            }

        });
        return $color;
    }
}