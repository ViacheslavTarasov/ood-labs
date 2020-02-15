<?php
declare(strict_types=1);

namespace Lab04\Shape;

use InvalidArgumentException;
use Lab04\Color\Color;
use Lab04\Common\Point;
use function Lab04\Helper\checkArraySize;

class ShapeFactory implements ShapeFactoryInterface
{
    public function createShape(string $description): Shape
    {
        $args = explode(' ', trim(str_replace('  ', ' ', $description)));
        $command = strtolower(trim($args[0]));
        switch ($command) {
            case 'rectangle':
                return $this->createRectangle($args);
            case 'triangle':
                return $this->createTriangle($args);
            case 'ellipse':
                return $this->createEllipse($args);
            case 'polygon':
                return $this->createRegularPolygon($args);
            default:
                throw new InvalidArgumentException('invalid shape description');
        }
    }

    private function createRectangle(array $args): Rectangle
    {
        checkArraySize(6, $args);
        return new Rectangle(
            $this->extractColorFromNextArgs($args),
            $this->extractPointFromNextArgs($args),
            $this->extractPointFromNextArgs($args)
        );
    }

    private function createTriangle(array $args): Triangle
    {
        checkArraySize(8, $args);
        return new Triangle(
            $this->extractColorFromNextArgs($args),
            $this->extractPointFromNextArgs($args),
            $this->extractPointFromNextArgs($args),
            $this->extractPointFromNextArgs($args)
        );
    }


    private function createEllipse(array $args): Ellipse
    {
        checkArraySize(6, $args);
        return new Ellipse(
            $this->extractColorFromNextArgs($args),
            $this->extractPointFromNextArgs($args),
            $this->extractIntFromNextArgs($args),
            $this->extractIntFromNextArgs($args)
        );
    }

    private function createRegularPolygon(array $args): RegularPolygon
    {
        checkArraySize(6, $args);
        return new RegularPolygon(
            $this->extractColorFromNextArgs($args),
            $this->extractPointFromNextArgs($args),
            $this->extractIntFromNextArgs($args),
            $this->extractIntFromNextArgs($args)
        );
    }

    private function extractIntFromNextArgs(array &$args): int
    {
        return (int)next($args);
    }

    private function extractColorFromNextArgs(array &$args): Color
    {
        return Color::createFromString(strtolower(trim(next($args))));
    }

    private function extractPointFromNextArgs(array &$args): Point
    {
        return new Point((int)next($args), (int)next($args));
    }
}