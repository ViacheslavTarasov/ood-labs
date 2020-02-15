<?php

use Lab04\Canvas\PngCanvas;
use Lab04\Color\Color;
use Lab04\Common\Point;
use Lab04\Shape\Rectangle;
use Lab04\Shape\RegularPolygon;
use Lab04\Shape\Triangle;
use PHPUnit\Framework\TestCase;

class PngCanvasTest extends TestCase
{
    private const IMAGE_PATH = __DIR__ . '/test.png';
    /** @var PngCanvas */
    private $canvas;

    public function setUp(): void
    {
        $this->canvas = new PngCanvas(800, 600, self::IMAGE_PATH);
        if (file_exists(self::IMAGE_PATH)) {
            unlink(self::IMAGE_PATH);
        }
    }

    public function testDrawImage(): void
    {
        $this->canvas->setColor(Color::createFromString(Color::GREEN));
        $this->canvas->drawLine(new Point(100, 10), new Point(100, 100));

        $this->canvas->setColor(Color::createFromString(Color::RED));
        $this->canvas->drawEllipse(new Point(100, 150), 300, 100);

        $rectangle = new Rectangle(Color::createFromString(Color::YELLOW), new Point(200, 200), new Point(300, 300));
        $rectangle->draw($this->canvas);
        $triangle = new Triangle(
            Color::createFromString(Color::PINK),
            new Point(210, 210),
            new Point(210, 280),
            new Point(280, 280)
        );
        $triangle->draw($this->canvas);

        $center = new Point(500, 300);
        $regularPolygon = new RegularPolygon(Color::createFromString(Color::BLUE), $center, 10, 200);
        $regularPolygon->draw($this->canvas);
        $regularPolygon = new RegularPolygon(Color::createFromString(Color::BLUE), $center, 8, 170);
        $regularPolygon->draw($this->canvas);
        $regularPolygon = new RegularPolygon(Color::createFromString(Color::BLUE), $center, 5, 130);
        $regularPolygon->draw($this->canvas);
        $regularPolygon = new RegularPolygon(Color::createFromString(Color::BLUE), $center, 4, 90);
        $regularPolygon->draw($this->canvas);
        $regularPolygon = new RegularPolygon(Color::createFromString(Color::BLUE), $center, 3, 50);
        $regularPolygon->draw($this->canvas);

        $this->assertTrue(file_exists(self::IMAGE_PATH));
    }
}
