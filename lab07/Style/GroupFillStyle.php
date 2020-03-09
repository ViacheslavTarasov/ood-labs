<?php
declare(strict_types=1);

namespace Lab07\Style;

use Lab07\Color\RgbaColor;

class GroupFillStyle implements StyleInterface
{
    /** @var FillStyleIterable */
    private $fillStyleIterable;

    public function __construct(FillStyleIterable $fillStyleIterable)
    {
        $this->fillStyleIterable = $fillStyleIterable;
    }

    public function isEnabled(): ?bool
    {
        $isEnabled = null;
        $first = true;
        $this->fillStyleIterable->iterateFillStyle(function (StyleInterface $style) use (&$isEnabled, &$first) {
            if ($first) {
                $isEnabled = $style->isEnabled();
                $first = null;
            }
            $isEnabled = $isEnabled !== $style->isEnabled() ? null : $style->isEnabled();
        });
        return $isEnabled;
    }

    public function enable(): void
    {
        $this->fillStyleIterable->iterateFillStyle(function (StyleInterface $style) {
            $style->enable();
        });
    }

    public function disable(): void
    {
        $this->fillStyleIterable->iterateFillStyle(function (StyleInterface $style) {
            $style->disable();
        });
    }

    public function setColor(RgbaColor $color): void
    {
        $this->fillStyleIterable->iterateFillStyle(function (StyleInterface $style) use ($color) {
            $style->setColor($color);
        });
    }

    public function getColor(): ?RgbaColor
    {
        $color = null;
        $first = true;
        $this->fillStyleIterable->iterateFillStyle(function (StyleInterface $style) use (&$color, &$first) {
            if ($first) {
                $color = $style->getColor();
                $first = false;
            }
            $color = $color != $style->getColor() ? null : $color;
        });
        return $color;
    }
}