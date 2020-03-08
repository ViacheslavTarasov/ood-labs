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

    public function isEnabled(): bool
    {
        $isEnabled = true;
        $this->fillStyleIterable->iterateFillStyle(function (StyleInterface $style) use (&$isEnabled) {
            $isEnabled = $isEnabled && $style->isEnabled();
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
        $ready = false;
        $this->fillStyleIterable->iterateFillStyle(function (StyleInterface $style) use (&$color, &$ready) {
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