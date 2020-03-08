<?php
declare(strict_types=1);

namespace Lab07\Style;

use Lab07\Color\RgbaColor;

abstract class Style implements StyleInterface
{
    /** @var RgbaColor */
    private $color;
    /** @var bool */
    private $enabled;

    public function __construct(RgbaColor $color, bool $enabled = true)
    {
        $this->color = $color;
        $this->enabled = $enabled;
    }

    public function getColor(): RgbaColor
    {
        return $this->color;
    }

    public function setColor(RgbaColor $color): void
    {
        $this->color = $color;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function enable(): void
    {
        $this->enabled = true;
    }

    public function disable(): void
    {
        $this->enabled = false;
    }
}