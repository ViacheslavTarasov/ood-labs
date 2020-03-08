<?php
declare(strict_types=1);

namespace Lab07\App;

use Lab07\Canvas\PngCanvas;
use Lab07\Canvas\TextCanvas;
use Lab07\Color\RgbaColor;
use Lab07\Shape\Ellipse;
use Lab07\Shape\Frame;
use Lab07\Shape\GroupShapes;
use Lab07\Shape\Point;
use Lab07\Shape\Polygon;
use Lab07\Shape\ShapeInterface;
use Lab07\Slide\Slide;
use Lab07\Style\FillStyle;
use Lab07\Style\LineStyle;

class App
{
    private const IMAGE_DIR = __DIR__ . DIRECTORY_SEPARATOR;

    public function run(): void
    {
        $slide = new Slide(800, 600);

        $textCanvas = new TextCanvas(new \SplFileObject('php://stdout', 'w'));
        $pngCanvas = new PngCanvas($slide->getWidth(), $slide->getHeight());

        $home = $this->getHomeGroupShapes();
        $sun = $this->getSunShape();
        $slide->insertShape($home, 0);
        $slide->insertShape($sun, 1);
        $slide->insertShape($this->getWindowsGroupShapes(), 2);

        $slide->draw($textCanvas);
        $slide->draw($pngCanvas);

        $pngCanvas->save(self::IMAGE_DIR . 'result1.png');

        $sun->getFillStyle()->setColor(new RgbaColor(255, 100, 0));
        $frame = $sun->getFrame();
        $sun->setFrame(new Frame(new Point(10, 10), 2 * $frame->getWidth(), 2 * $frame->getHeight()));

        $slide->draw($textCanvas);
        $slide->draw($pngCanvas);
        $pngCanvas->save(self::IMAGE_DIR . 'result2.png');

        $homeFrame = $home->getFrame();
        $home->setFrame(new Frame(new Point(300, 100), $homeFrame->getWidth() - 50, $homeFrame->getHeight() - 50));

        $home->getLineStyle()->setColor(new RgbaColor(150, 0, 0));
        $home->getLineStyle()->setThickness(5);

        $home->getFillStyle()->setColor(new RgbaColor(100, 150, 0));

        $slide->draw($textCanvas);
        $slide->draw($pngCanvas);
        $pngCanvas->save(self::IMAGE_DIR . 'result3.png');
    }

    private function getSunShape(): ShapeInterface
    {
        $color = new RgbaColor(255, 160, 0);
        $lineStyle = new LineStyle($color, false);
        $fillStyle = new FillStyle($color);
        return new Ellipse($lineStyle, $fillStyle, new Point(600, 200), 100, 100);
    }

    private function getHomeGroupShapes(): ShapeInterface
    {
        $group = new GroupShapes();

        $wallLineStyle = new LineStyle(new RgbaColor(100, 200, 200), true, 10);
        $wallFillStyle = new FillStyle(new RgbaColor(50, 70, 200));
        $wall = new Polygon($wallLineStyle, $wallFillStyle, [
            new Point(200, 300), new Point(400, 300),
            new Point(400, 500), new Point(200, 500)
        ]);

        $roofLineStyle = new LineStyle(new RgbaColor(200, 100, 5), true, 2);
        $roofFillStyle = new FillStyle(new RgbaColor(77, 154, 50));
        $roof = new Polygon($roofLineStyle, $roofFillStyle, [
            new Point(300, 100),
            new Point(150, 299), new Point(450, 299)
        ]);

        $group->insertShape($wall, 0);
        $group->insertShape($roof, 1);

        return $group;
    }

    private function getWindowsGroupShapes(): ShapeInterface
    {
        return new GroupShapes();
    }
}