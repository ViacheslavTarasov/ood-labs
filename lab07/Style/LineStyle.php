<?php
declare(strict_types=1);

namespace Lab07\Style;

use Lab07\Color\RgbaColor;

class LineStyle extends Style implements LineStyleInterface
{
    /** @var int */
    private $thickness;

    public function __construct(RgbaColor $color, bool $enabled = true, int $thickness = 1)
    {
        $this->thickness = $thickness;
        parent::__construct($color, $enabled);
    }

    public function getThickness(): int
    {
        return $this->thickness;
    }

    public function setThickness(int $thickness): void
    {
        $this->thickness = $thickness;
    }
}