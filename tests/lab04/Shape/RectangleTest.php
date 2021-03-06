<?php
declare(strict_types=1);

use Lab04\Canvas\CanvasInterface;
use Lab04\Color\Color;
use Lab04\Common\Point;
use Lab04\Shape\Rectangle;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RectangleTest extends TestCase
{
    /** @var Rectangle */
    private $rectangle;
    /** @var Color|MockObject */
    private $color;
    /** @var Point */
    private $leftTop;
    /** @var Point */
    private $rightTop;
    /** @var Point */
    private $rightBottom;
    /** @var Point */
    private $leftBottom;
    /** @var CanvasInterface|MockObject */
    private $canvas;

    public function setUp(): void
    {
        $this->color = $this->createMock(Color::class);

        $this->leftTop = new Point(10, 20);
        $this->rightBottom = new Point(30, 40);
        $this->rightTop = new Point($this->rightBottom->getX(), $this->leftTop->getY());
        $this->leftBottom = new Point($this->leftTop->getX(), $this->rightBottom->getY());

        $this->canvas = $this->createMock(CanvasInterface::class);

        $this->rectangle = new Rectangle($this->color, $this->leftTop, $this->rightBottom);
    }

    public function testGetColor(): void
    {
        $this->assertTrue($this->color === $this->rectangle->getColor());
    }

    public function testGetLeftTop(): void
    {
        $this->assertTrue($this->leftTop === $this->rectangle->getLeftTop());
    }

    public function testGetRightBottom(): void
    {
        $this->assertTrue($this->rightBottom === $this->rectangle->getRightBottom());
    }

    public function testDraw(): void
    {
        $this->canvas->expects($this->once())
            ->method('setColor')->with($this->equalTo($this->color));
        $this->canvas->expects($this->exactly(4))
            ->method('drawLine')
            ->withConsecutive(
                [$this->equalTo($this->leftTop), $this->equalTo($this->rightTop)],
                [$this->equalTo($this->rightTop), $this->equalTo($this->rightBottom)],
                [$this->equalTo($this->rightBottom), $this->equalTo($this->leftBottom)],
                [$this->equalTo($this->leftBottom), $this->equalTo($this->leftTop)]
            );

        $this->rectangle->draw($this->canvas);
    }
}
