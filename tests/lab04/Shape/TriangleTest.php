<?php


use Lab04\Canvas\CanvasInterface;
use Lab04\Color\ColorInterface;
use Lab04\Common\Coordinates;
use Lab04\Shape\Triangle;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TriangleTest extends TestCase
{
    /** @var Triangle */
    private $triangle;
    /** @var ColorInterface|MockObject */
    private $color;
    /** @var Coordinates */
    private $vertex1;
    /** @var Coordinates */
    private $vertex2;
    /** @var Coordinates */
    private $vertex3;
    /** @var CanvasInterface|MockObject */
    private $canvas;

    public function setUp(): void
    {
        $this->color = $this->createMock(ColorInterface::class);

        $this->vertex1 = new Coordinates(10, 20);
        $this->vertex2 = new Coordinates(30, 40);
        $this->vertex3 = new Coordinates(50, 60);

        $this->canvas = $this->createMock(CanvasInterface::class);

        $this->triangle = new Triangle($this->color, $this->vertex1, $this->vertex2, $this->vertex3);
    }

    public function testGetColor(): void
    {
        $this->assertTrue($this->color === $this->triangle->getColor());
    }

    public function testGetVertexes()
    {
        $this->assertTrue($this->vertex1 === $this->triangle->getVertex1());
        $this->assertTrue($this->vertex2 === $this->triangle->getVertex2());
        $this->assertTrue($this->vertex3 === $this->triangle->getVertex3());
    }

    public function testDraw()
    {
        $this->canvas->expects($this->once())
            ->method('setColor')->with($this->equalTo($this->color));
        $this->canvas->expects($this->exactly(3))
            ->method('drawLine')
            ->withConsecutive(
                [$this->equalTo($this->vertex1), $this->equalTo($this->vertex2)],
                [$this->equalTo($this->vertex2), $this->equalTo($this->vertex3)],
                [$this->equalTo($this->vertex3), $this->equalTo($this->vertex1)]
            );

        $this->triangle->draw($this->canvas);
    }
}
