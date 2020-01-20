<?php

use Lab04\Canvas\PngCanvas;
use Lab04\Color\ColorFactory;
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
    /** @var ColorFactory */
    private $colorFactory;

    public function setUp(): void
    {
        $this->colorFactory = new ColorFactory();
        $this->canvas = new PngCanvas(800, 600, self::IMAGE_PATH);
        if (file_exists(self::IMAGE_PATH)) {
            unlink(self::IMAGE_PATH);
        }
    }

    public function testDrawImage()
    {
        $this->canvas->setColor($this->colorFactory->create(ColorFactory::GREEN));
        $this->canvas->drawLine(new Point(100, 10), new Point(100, 100));

        $this->canvas->setColor($this->colorFactory->create(ColorFactory::RED));
        $this->canvas->drawEllipse(new Point(100, 150), 300, 100);

        $rectangle = new Rectangle($this->colorFactory->create(ColorFactory::YELLOW), new Point(200, 200), new Point(300, 300));
        $rectangle->draw($this->canvas);
        $triangle = new Triangle(
            $this->colorFactory->create(ColorFactory::PINK),
            new Point(210, 210),
            new Point(210, 280),
            new Point(280, 280)
        );
        $triangle->draw($this->canvas);

        $center = new Point(500, 300);
        $regularPolygon = new RegularPolygon($this->colorFactory->create(ColorFactory::BLUE), $center, 10, 200);
        $regularPolygon->draw($this->canvas);
        $regularPolygon = new RegularPolygon($this->colorFactory->create(ColorFactory::BLUE), $center, 8, 170);
        $regularPolygon->draw($this->canvas);
        $regularPolygon = new RegularPolygon($this->colorFactory->create(ColorFactory::BLUE), $center, 5, 130);
        $regularPolygon->draw($this->canvas);
        $regularPolygon = new RegularPolygon($this->colorFactory->create(ColorFactory::BLUE), $center, 4, 90);
        $regularPolygon->draw($this->canvas);
        $regularPolygon = new RegularPolygon($this->colorFactory->create(ColorFactory::BLUE), $center, 3, 50);
        $regularPolygon->draw($this->canvas);

        $this->assertTrue(file_exists(self::IMAGE_PATH));
    }
}
