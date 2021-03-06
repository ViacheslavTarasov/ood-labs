<?php
declare(strict_types=1);

namespace Lab06\App;

use Lab06\App\Adapter\ModernGraphicsRendererAdapter;
use Lab06\GraphicsLib\Canvas;
use Lab06\ModernGraphicsLib\ModernGraphicsRenderer;
use Lab06\ShapeDrawingLib\CanvasPainter;
use Lab06\ShapeDrawingLib\Point;
use Lab06\ShapeDrawingLib\Rectangle;
use Lab06\ShapeDrawingLib\Triangle;
use SplFileObject;

class App
{
    /** @var \SplFileObject */
    private $stdout;

    public function run(): void
    {
        $this->stdout = new SplFileObject('php://stdout', 'w');
        $line = readline("Should we use new API (y)? ");
        if (trim(mb_strtolower($line)) === 'y') {
            $this->paintPictureOnModernGraphicsRenderer();
        } else {
            $this->paintPictureOnCanvas();
        }
    }

    private function paintPicture(CanvasPainter $painter): void
    {
        $triangle = new Triangle(new Point(100, 200), new Point(100, 400), new Point(300, 350), '#FFAA00');
        $rectangle = new Rectangle(new Point(250, 250), 200, 300, '#336699');
        $painter->draw($triangle);
        $painter->draw($rectangle);
    }

    private function paintPictureOnCanvas(): void
    {
        $simpleCanvas = new Canvas();
        $painter = new CanvasPainter($simpleCanvas);
        $this->paintPicture($painter);
    }

    private function paintPictureOnModernGraphicsRenderer(): void
    {
        $modernRenderer = new ModernGraphicsRenderer($this->stdout);
        $modernRenderer->beginDraw();
        $modernCanvas = new ModernGraphicsRendererAdapter($modernRenderer);
        $painter = new CanvasPainter($modernCanvas);
        $this->paintPicture($painter);
        $modernRenderer->endDraw();
    }
}