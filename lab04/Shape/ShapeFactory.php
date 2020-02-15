<?php
declare(strict_types=1);

namespace Lab04\Shape;

use Lab04\Color\Color;
use Lab04\Common\Point;

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
                throw new \InvalidArgumentException('invalid shape description');
        }
    }

    private function createRectangle(array $args): Rectangle
    {
        $this->assertCount(6, $args);
        return new Rectangle(
            $this->extractColorFromNextArgs($args),
            $this->extractPointFromNextArgs($args),
            $this->extractPointFromNextArgs($args)
        );
    }

    private function createTriangle(array $args): Triangle
    {
        $this->assertCount(8, $args);
        return new Triangle(
            $this->extractColorFromNextArgs($args),
            $this->extractPointFromNextArgs($args),
            $this->extractPointFromNextArgs($args),
            $this->extractPointFromNextArgs($args)
        );
    }


    private function createEllipse(array $args): Ellipse
    {
        $this->assertCount(6, $args);
        return new Ellipse(
            $this->extractColorFromNextArgs($args),
            $this->extractPointFromNextArgs($args),
            $this->extractIntFromNextArgs($args),
            $this->extractIntFromNextArgs($args)
        );
    }

    private function createRegularPolygon(array $args): RegularPolygon
    {
        $this->assertCount(6, $args);
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

    /**
     * @param int $count
     * @param array $data
     * @throws \InvalidArgumentException
     */
    private function assertCount(int $count, array $data): void
    {
        if (count($data) !== $count) {
            throw new \InvalidArgumentException('invalid count arguments');
        }
    }

}