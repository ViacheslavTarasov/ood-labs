<?php

use Lab04\Canvas\CanvasInterface;
use Lab04\Color\Color;
use Lab04\Common\Point;
use Lab04\Shape\Triangle;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TriangleTest extends TestCase
{
    /** @var Triangle */
    private $triangle;
    /** @var Color|MockObject */
    private $color;
    /** @var Point */
    private $vertex1;
    /** @var Point */
    private $vertex2;
    /** @var Point */
    private $vertex3;
    /** @var CanvasInterface|MockObject */
    private $canvas;

    public function setUp(): void
    {
        $this->color = $this->createMock(Color::class);

        $this->vertex1 = new Point(10, 20);
        $this->vertex2 = new Point(30, 40);
        $this->vertex3 = new Point(50, 60);

        $this->canvas = $this->createMock(CanvasInterface::class);

        $this->triangle = new Triangle($this->color, $this->vertex1, $this->vertex2, $this->vertex3);
    }

    public function testGetColor(): void
    {
        $this->assertTrue($this->color === $this->triangle->getColor());
    }

    public function testGetVertexes(): void
    {
        $this->assertTrue($this->vertex1 === $this->triangle->getVertex1());
        $this->assertTrue($this->vertex2 === $this->triangle->getVertex2());
        $this->assertTrue($this->vertex3 === $this->triangle->getVertex3());
    }

    public function testDraw(): void
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
