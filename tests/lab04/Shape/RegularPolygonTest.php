<?php


use Lab04\Canvas\CanvasInterface;
use Lab04\Color\ColorInterface;
use Lab04\Common\Coordinates;
use Lab04\Shape\RegularPolygon;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RegularPolygonTest extends TestCase
{
    /** @var RegularPolygon */
    private $polygon;
    /** @var ColorInterface|MockObject */
    private $color;
    /** @var Coordinates */
    private $center;
    /** @var int */
    private $vertexCount;
    /** @var int */
    private $radius;
    /** @var CanvasInterface|MockObject */
    private $canvas;

    public function setUp(): void
    {
        $this->color = $this->createMock(ColorInterface::class);

        $this->center = new Coordinates(10, 20);
        $this->vertexCount = 6;
        $this->radius = 30;
        $this->canvas = $this->createMock(CanvasInterface::class);
        $this->polygon = new RegularPolygon($this->color, $this->center, $this->vertexCount, $this->radius);
    }


    public function testGetters()
    {
        $this->assertTrue($this->color === $this->polygon->getColor());
        $this->assertTrue($this->center === $this->polygon->getCenter());
        $this->assertTrue($this->vertexCount === $this->polygon->getVertexCount());
        $this->assertTrue($this->radius === $this->polygon->getRadius());
    }

    public function testDraw()
    {
        $this->canvas->expects($this->once())
            ->method('setColor')->with($this->equalTo($this->color));

        $this->canvas->expects($this->exactly($this->vertexCount))
            ->method('drawLine');
        $this->polygon->draw($this->canvas);
    }
}
