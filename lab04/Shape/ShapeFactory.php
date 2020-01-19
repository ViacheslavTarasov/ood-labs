<?php
declare(strict_types=1);

namespace Lab04\Shape;

use Lab04\Color\ColorFactory;
use Lab04\Color\ColorInterface;
use Lab04\Common\Coordinates;

class ShapeFactory implements ShapeFactoryInterface
{
    public function createShape(string $description): ShapeInterface
    {
        $args = explode(' ', $description);
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
            $this->extractCoordinatesFromNextArgs($args),
            $this->extractCoordinatesFromNextArgs($args)
        );
    }

    private function createTriangle(array $args): Triangle
    {
        $this->assertCount(8, $args);
        return new Triangle(
            $this->extractColorFromNextArgs($args),
            $this->extractCoordinatesFromNextArgs($args),
            $this->extractCoordinatesFromNextArgs($args),
            $this->extractCoordinatesFromNextArgs($args)
        );
    }


    private function createEllipse(array $args): Ellipse
    {
        $this->assertCount(6, $args);
        return new Ellipse(
            $this->extractColorFromNextArgs($args),
            $this->extractCoordinatesFromNextArgs($args),
            $this->extractIntFromNextArgs($args),
            $this->extractIntFromNextArgs($args)
        );
    }

    private function createRegularPolygon(array $args): RegularPolygon
    {
        $this->assertCount(6, $args);
        return new RegularPolygon(
            $this->extractColorFromNextArgs($args),
            $this->extractCoordinatesFromNextArgs($args),
            $this->extractIntFromNextArgs($args),
            $this->extractIntFromNextArgs($args)
        );
    }

    private function extractIntFromNextArgs(array &$args): int
    {
        return (int)next($args);
    }


    private function extractColorFromNextArgs(array &$args): ColorInterface
    {
        return ColorFactory::create(strtolower(trim(next($args))));
    }

    private function extractCoordinatesFromNextArgs(array &$args): Coordinates
    {
        return new Coordinates((int)next($args), (int)next($args));
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