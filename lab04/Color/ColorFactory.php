<?php
declare(strict_types=1);

namespace Lab04\Color;

class ColorFactory implements ColorFactoryInterface
{
    public const GREEN = 'green';
    public const RED = 'red';
    public const BLUE = 'blue';
    public const YELLOW = 'yellow';
    public const PINK = 'pink';
    public const BLACK = 'black';

    /**
     * @param string $name
     * @return ColorInterface
     * @throws \InvalidArgumentException
     */
    public function create(string $name): ColorInterface
    {
        switch (strtolower($name)) {
            case self::GREEN:
                return new Color(0, 128, 0);
            case self::RED:
                return new Color(255, 0, 0);
            case self::BLUE:
                return new Color(0, 0, 255);
            case self::YELLOW:
                return new Color(255, 255, 0);
            case self::PINK:
                return new Color(255, 192, 203);
            case self::BLACK:
                return new Color(0, 0, 0);
            default:
                throw  new \InvalidArgumentException('Invalid color name');
        }

    }
}