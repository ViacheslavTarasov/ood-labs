<?php
declare(strict_types=1);

namespace Lab06\ModernGraphicsLib;

use LogicException;
use SplFileObject;

class ModernGraphicsRenderer
{
    /** @var SplFileObject */
    private $stdout;
    /** @var bool */
    private $drawing = false;

    public function __construct(SplFileObject $stdout)
    {
        $this->stdout = $stdout;
    }

    public function __destruct()
    {
        if ($this->drawing) {
            $this->endDraw();
        }
    }

    public function beginDraw(): void
    {
        if ($this->drawing) {
            throw new LogicException('Drawing has already begun');
        }
        $this->stdout->fwrite('<draw>' . PHP_EOL);
        $this->drawing = true;
    }

    public function drawLine(Point $start, Point $end, RgbaColor $color): void
    {
        if (!$this->drawing) {
            throw new LogicException('DrawLine is allowed between BeginDraw()/EndDraw() only');
        }
        $content = sprintf('<line fromX="%d" fromY="%d" toX="%d" toY="%d"/>', $start->getX(), $start->getY(), $end->getX(), $end->getY()) . PHP_EOL;
        $content .= sprintf('<color r="%f" g="%f" b="%f" a="%f"/>', $color->getR(), $color->getG(), $color->getB(), $color->getAlpha()) . PHP_EOL;
        $content .= '</line>' . PHP_EOL;
        $this->stdout->fwrite($content);
    }

    public function endDraw(): void
    {
        if (!$this->drawing) {
            throw new LogicException('Drawing has not been started');
        }
        $this->stdout->fwrite('</draw>' . PHP_EOL);
        $this->drawing = false;
    }
}