<?php


use Lab04\Canvas\CanvasInterface;
use Lab04\Color\ColorInterface;
use Lab04\Common\Point;
use Lab04\Shape\Ellipse;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class EllipseTest extends TestCase
{
    /** @var Ellipse */
    private $ellipse;
    /** @var ColorInterface|MockObject */
    private $color;
    /** @var Point */
    private $center;
    /** @var int */
    private $width;
    /** @var int */
    private $height;
    /** @var CanvasInterface|MockObject */
    private $canvas;

    public function setUp(): void
    {
        $this->color = $this->createMock(ColorInterface::class);

        $this->center = new Point(10, 20);
        $this->width = 60;
        $this->height = 30;
        $this->canvas = $this->createMock(CanvasInterface::class);
        $this->ellipse = new Ellipse($this->color, $this->center, $this->width, $this->height);
    }


    public function testGetters()
    {
        $this->assertTrue($this->color === $this->ellipse->getColor());
        $this->assertTrue($this->center === $this->ellipse->getCenter());
        $this->assertTrue($this->width === $this->ellipse->getWidth());
        $this->assertTrue($this->height === $this->ellipse->getHeight());
    }

    public function testDraw()
    {
        $this->canvas->expects($this->once())
            ->method('setColor')->with($this->equalTo($this->color));
        $this->canvas->expects($this->exactly(1))
            ->method('drawEllipse')
            ->withConsecutive(
                [$this->equalTo($this->center), $this->equalTo($this->width), $this->equalTo($this->height)]
            );

        $this->ellipse->draw($this->canvas);
    }
}
