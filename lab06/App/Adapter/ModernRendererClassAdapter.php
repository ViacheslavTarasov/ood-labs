<?php
declare(strict_types=1);

namespace Lab06\App\Adapter;

use Lab06\GraphicsLib\CanvasInterface;
use Lab06\ModernGraphicsLib\ModernGraphicsRenderer;
use Lab06\ModernGraphicsLib\Point;
use SplFileObject;

class ModernRendererClassAdapter extends ModernGraphicsRenderer implements CanvasInterface
{
    /** @var Point */
    private $start;

    public function __construct(SplFileObject $stdout)
    {
        parent::__construct($stdout);
        $this->start = new Point(0, 0);
        $this->beginDraw();
    }

    public function moveTo(int $x, int $y): void
    {
        $this->start = new Point($x, $y);
    }

    public function lineTo(int $x, int $y): void
    {
        $end = new Point($x, $y);
        $this->drawLine($this->start, $end);
        $this->start = $end;
    }
}