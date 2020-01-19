<?php

use Lab04\Canvas\PngCanvas;
use Lab04\Color\ColorFactory;
use Lab04\Common\Coordinates;
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

    public function testDrawImage()
    {
        $this->canvas->setColor(ColorFactory::create(ColorFactory::GREEN));
        $this->canvas->drawLine(new Coordinates(100, 10), new Coordinates(100, 100));

        $this->canvas->setColor(ColorFactory::create(ColorFactory::RED));
        $this->canvas->drawEllipse(new Coordinates(100, 150), 300, 100);

        $rectangle = new Rectangle(ColorFactory::create(ColorFactory::YELLOW), new Coordinates(200, 200), new Coordinates(300, 300));
        $rectangle->draw($this->canvas);
        $triangle = new Triangle(
            ColorFactory::create(ColorFactory::PINK),
            new Coordinates(210, 210),
            new Coordinates(210, 280),
            new Coordinates(280, 280)
        );
        $triangle->draw($this->canvas);

        $center = new Coordinates(500, 300);
        $regularPolygon = new RegularPolygon(ColorFactory::create(ColorFactory::BLUE), $center, 10, 200);
        $regularPolygon->draw($this->canvas);
        $regularPolygon = new RegularPolygon(ColorFactory::create(ColorFactory::BLUE), $center, 8, 170);
        $regularPolygon->draw($this->canvas);
        $regularPolygon = new RegularPolygon(ColorFactory::create(ColorFactory::BLUE), $center, 5, 130);
        $regularPolygon->draw($this->canvas);
        $regularPolygon = new RegularPolygon(ColorFactory::create(ColorFactory::BLUE), $center, 4, 90);
        $regularPolygon->draw($this->canvas);
        $regularPolygon = new RegularPolygon(ColorFactory::create(ColorFactory::BLUE), $center, 3, 50);
        $regularPolygon->draw($this->canvas);

        $this->assertTrue(file_exists(self::IMAGE_PATH));
    }
}
