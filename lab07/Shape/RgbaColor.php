<?php
declare(strict_types=1);

namespace Lab07\Shape;

class RgbaColor
{
    /** @var int */
    private $r;
    /** @var int */
    private $g;
    /** @var int */
    private $b;
    /** @var int */
    private $alpha;

    public function __construct(int $r, int $g, int $b, int $alpha = 0)
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
        $this->alpha = $alpha;
    }

    public function getR(): int
    {
        return $this->r;
    }

    public function getG(): int
    {
        return $this->g;
    }

    public function getB(): int
    {
        return $this->b;
    }

    public function getAlpha(): int
    {
        return $this->alpha;
    }
}