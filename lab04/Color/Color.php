<?php
declare(strict_types=1);

namespace Lab04\Color;

use InvalidArgumentException;

class Color
{
    public const GREEN = 'green';
    public const RED = 'red';
    public const BLUE = 'blue';
    public const YELLOW = 'yellow';
    public const PINK = 'pink';
    public const BLACK = 'black';

    /** @var int */
    private $r;
    /** @var int */
    private $g;
    /** @var int */
    private $b;

    public function __construct(int $r, int $g, int $b)
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
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

    /**
     * @param string $name
     * @return Color
     */
    public static function createFromString(string $name): Color
    {
        switch (strtolower($name)) {
            case self::GREEN:
                return new self(0, 128, 0);
            case self::RED:
                return new self(255, 0, 0);
            case self::BLUE:
                return new self(0, 0, 255);
            case self::YELLOW:
                return new self(255, 255, 0);
            case self::PINK:
                return new self(255, 192, 203);
            case self::BLACK:
                return new self(0, 0, 0);
            default:
                throw  new InvalidArgumentException('Invalid color name');
        }
    }
}