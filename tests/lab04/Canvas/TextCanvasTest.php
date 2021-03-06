<?php

use Lab04\Canvas\TextCanvas;
use Lab04\Color\Color;
use Lab04\Common\Point;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TextCanvasTest extends TestCase
{
    private const COLOR_R = 1;
    private const COLOR_G = 1;
    private const COLOR_B = 1;
    private const WIDTH = 50;
    private const HEIGHT = 70;
    /** @var TextCanvas */
    private $canvas;
    /** @var SplFileObject|MockObject */
    private $outStream;
    /** @var Point */
    private $vertex1;
    /** @var Point */
    private $vertex2;
    /** @var Color */
    private $color;

    public function setUp(): void
    {
        $this->vertex1 = new Point(10, 20);
        $this->vertex2 = new Point(30, 40);
        $this->outStream = new SplTempFileObject(-1);
        $this->color = $this->createMock(Color::class);
        $this->color->method('getR')->willReturn(self::COLOR_R);
        $this->color->method('getG')->willReturn(self::COLOR_G);
        $this->color->method('getB')->willReturn(self::COLOR_B);
        $this->canvas = new TextCanvas($this->outStream);
    }

    public function testDrawEllipse(): void
    {
        $text = "draw ellipse: center - ({$this->vertex1->getX()},{$this->vertex1->getY()}), width - " . self::WIDTH . ", height - " . self::HEIGHT . PHP_EOL;
        $this->canvas->drawEllipse($this->vertex1, self::WIDTH, self::HEIGHT);
        $this->assertEqualsText($text);
    }

    public function testDrawLine(): void
    {
        $text = "draw line from ({$this->vertex1->getX()},{$this->vertex1->getY()}) to ({$this->vertex2->getX()},{$this->vertex2->getY()})" . PHP_EOL;
        $this->canvas->drawLine($this->vertex1, $this->vertex2);
        $this->assertEqualsText($text);
    }

    public function testSetColor(): void
    {
        $text = 'set pen color: ' . self::COLOR_R . ' ' . self::COLOR_G . ' ' . self::COLOR_B . PHP_EOL;
        $this->canvas->setColor($this->color);
        $this->assertEqualsText($text);
    }

    private function assertEqualsText(string $text): void
    {
        $this->outStream->rewind();
        $this->assertEquals($text, $this->outStream->current());
    }
}
