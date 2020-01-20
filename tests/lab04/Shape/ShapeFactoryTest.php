<?php
declare(strict_types=1);

use Lab04\Color\ColorFactory;
use Lab04\Color\ColorInterface;
use Lab04\Common\Point;
use Lab04\Shape\Ellipse;
use Lab04\Shape\Rectangle;
use Lab04\Shape\RegularPolygon;
use Lab04\Shape\ShapeFactory;
use Lab04\Shape\Triangle;
use PHPUnit\Framework\TestCase;

class ShapeFactoryTest extends TestCase
{
    private const VERTEX_1_X = 10;
    private const VERTEX_1_Y = 20;
    private const VERTEX_2_X = 30;
    private const VERTEX_2_Y = 40;
    private const VERTEX_3_X = 54;
    private const VERTEX_3_Y = 62;
    private const WIDTH = 100;
    private const HEIGHT = 50;
    private const RADIUS = 100;
    private const VERTEX_COUNT = 8;
    private const COLOR = ColorFactory::RED;
    private const RECTANGLE_COMMAND = 'rectangle';
    private const TRIANGLE_COMMAND = 'triangle';
    private const ELLIPSE_COMMAND = 'ellipse';
    private const POLYGON_COMMAND = 'polygon';

    /** @var ShapeFactory */
    private $shapeFactory;
    private $colorFactory;
    private $color;

    public function setUp(): void
    {
        $this->color = $this->createMock(ColorInterface::class);
        $this->color->method('getR')->willReturn(255);
        $this->color->method('getG')->willReturn(0);
        $this->color->method('getB')->willReturn(0);
        $this->colorFactory = $this->createMock(ColorFactory::class);
        $this->colorFactory->method('create')->willReturn($this->color);
        $this->shapeFactory = new ShapeFactory($this->colorFactory);
    }

    public function testCreateRectangle(): void
    {
        $description = $this->getRectangleDescription(self::COLOR, self::VERTEX_1_X,
            self::VERTEX_1_Y, self::VERTEX_2_X, self::VERTEX_2_Y);
        /** @var Rectangle $shape */
        $shape = $this->shapeFactory->createShape($description);
        $this->assertInstanceOf(Rectangle::class, $shape);
        $this->assertEquals($this->color, $shape->getColor());
        $this->assertEquals(new Point(self::VERTEX_1_X, self::VERTEX_1_Y), $shape->getLeftTop());
        $this->assertEquals(new Point(self::VERTEX_2_X, self::VERTEX_2_Y), $shape->getRightBottom());
    }

    public function testInvalidCountArgumentsWhenCreateRectangle(): void
    {
        $description = $this->getRectangleDescription('', self::VERTEX_1_X, self::VERTEX_1_Y,
            self::VERTEX_2_X, self::VERTEX_2_Y);
        $this->expectInvalidArgumentException($description);
    }

    public function testCreateTriangle(): void
    {
        $description = $this->getTriangleDescription(self::COLOR, self::VERTEX_1_X, self::VERTEX_1_Y,
            self::VERTEX_2_X, self::VERTEX_2_Y, self::VERTEX_3_X, self::VERTEX_3_Y);
        /** @var Triangle $shape */
        $shape = $this->shapeFactory->createShape($description);
        $this->assertInstanceOf(Triangle::class, $shape);
        $this->assertEquals($this->color, $shape->getColor());
        $this->assertEquals(new Point(self::VERTEX_1_X, self::VERTEX_1_Y), $shape->getVertex1());
        $this->assertEquals(new Point(self::VERTEX_2_X, self::VERTEX_2_Y), $shape->getVertex2());
        $this->assertEquals(new Point(self::VERTEX_3_X, self::VERTEX_3_Y), $shape->getVertex3());
    }

    public function testInvalidCountArgumentsWhenCreateTriangle(): void
    {
        $description = $this->getTriangleDescription('', self::VERTEX_1_X, self::VERTEX_1_Y,
            self::VERTEX_2_X, self::VERTEX_2_Y, self::VERTEX_3_X, self::VERTEX_3_Y);
        $this->expectInvalidArgumentException($description);
    }

    public function testCreateEllipse(): void
    {
        $description = $this->getEllipseleDescription(self::COLOR, self::VERTEX_1_X, self::VERTEX_1_Y,
            self::WIDTH, self::HEIGHT);
        /** @var Ellipse $shape */
        $shape = $this->shapeFactory->createShape($description);
        $this->assertInstanceOf(Ellipse::class, $shape);
        $this->assertEquals($this->color, $shape->getColor());
        $this->assertEquals(new Point(self::VERTEX_1_X, self::VERTEX_1_Y), $shape->getCenter());
        $this->assertEquals(self::HEIGHT, $shape->getHeight());
        $this->assertEquals(self::WIDTH, $shape->getWidth());
    }

    public function testInvalidCountArgumentsWhenCreateEllipse(): void
    {
        $description = $this->getEllipseleDescription('', self::VERTEX_1_X, self::VERTEX_1_Y,
            self::WIDTH, self::HEIGHT);
        $this->expectInvalidArgumentException($description);
    }

    public function testCreatePolygon(): void
    {
        $description = $this->getPolygonDescription(self::COLOR, self::VERTEX_1_X, self::VERTEX_1_Y,
            self::VERTEX_COUNT, self::RADIUS);
        /** @var RegularPolygon $shape */
        $shape = $this->shapeFactory->createShape($description);
        $this->assertInstanceOf(RegularPolygon::class, $shape);
        $this->assertEquals($this->color, $shape->getColor());
        $this->assertEquals(new Point(self::VERTEX_1_X, self::VERTEX_1_Y), $shape->getCenter());
        $this->assertEquals(self::VERTEX_COUNT, $shape->getVertexCount());
        $this->assertEquals(self::RADIUS, $shape->getRadius());
    }

    public function testInvalidCountArgumentsWhenCreatePolygon(): void
    {
        $description = $this->getPolygonDescription('', self::VERTEX_1_X, self::VERTEX_1_Y,
            self::VERTEX_COUNT, self::RADIUS);
        $this->expectInvalidArgumentException($description);
    }

    private function getRectangleDescription($color, $leftTopX, $leftTopY, $rightBottomX, $rightBottomY): string
    {
        return self::RECTANGLE_COMMAND . " $color $leftTopX $leftTopY $rightBottomX $rightBottomY";
    }

    private function getTriangleDescription($color, $vertex1X, $vertex1Y, $vertex2X, $vertex2Y, $vertex3X, $vertex3Y): string
    {
        return self::TRIANGLE_COMMAND . " $color $vertex1X $vertex1Y $vertex2X $vertex2Y $vertex3X $vertex3Y";
    }

    private function getEllipseleDescription($color, $centerX, $centerY, $width, $height): string
    {
        return self::ELLIPSE_COMMAND . " $color $centerX $centerY $width $height";
    }

    private function getPolygonDescription($color, $centerX, $centerY, $vertexCount, $radius): string
    {
        return self::POLYGON_COMMAND . " $color $centerX $centerY $vertexCount $radius";
    }

    private function expectInvalidArgumentException(string $description)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->shapeFactory->createShape($description);
    }
}
