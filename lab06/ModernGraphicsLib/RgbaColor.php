<?php
declare(strict_types=1);

namespace Lab06\ModernGraphicsLib;

class RgbaColor
{
    public const MIN_VALUE = 0;
    public const MAX_VALUE = 1;

    /** @var int */
    private $r;
    /** @var int */
    private $g;
    /** @var int */
    private $b;
    /** @var int */
    private $alpha;

    public function __construct(float $r, float $g, float $b, float $alpha)
    {
        $this->checkValueInInervalOrException($r);
        $this->checkValueInInervalOrException($g);
        $this->checkValueInInervalOrException($b);
        $this->checkValueInInervalOrException($alpha);

        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
        $this->alpha = $alpha;
    }

    public function getR(): float
    {
        return $this->r;
    }

    public function getG(): float
    {
        return $this->g;
    }

    public function getB(): float
    {
        return $this->b;
    }

    public function getAlpha(): float
    {
        return $this->alpha;
    }

    private function checkValueInInervalOrException(float $value): void
    {
        if ($value < self::MIN_VALUE || $value > self::MAX_VALUE) {
            throw new \InvalidArgumentException('invalid color param');
        }
    }
}