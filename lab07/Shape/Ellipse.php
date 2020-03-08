<?php
declare(strict_types=1);

namespace Lab07\Shape;

use Lab07\Canvas\CanvasInterface;
use Lab07\Style\LineStyleInterface;
use Lab07\Style\StyleInterface;

class Ellipse extends Shape
{
    /**
     * @var PointTransformationService
     */
    private $pointTransformationService;
    /** @var Frame */
    private $frame;
    /** @var Point */
    private $center;
    /** @var int */
    private $width;
    /** @var int */
    private $height;

    public function __construct(LineStyleInterface $lineStyle, StyleInterface $fillStyle, Point $center, int $width, int $height)
    {
        $this->pointTransformationService = new PointTransformationService();
        $this->center = $center;
        $this->width = $width;
        $this->height = $height;
        parent::__construct($lineStyle, $fillStyle);
    }

    public function draw(CanvasInterface $canvas): void
    {
        $fillStyle = $this->getFillStyle();
        if ($fillStyle->isEnabled()) {
            $canvas->setFillColor($fillStyle->getColor());
            $canvas->drawFilledEllipse($this->center, $this->width, $this->height);
        }

        $lineStyle = $this->getLineStyle();
        if ($lineStyle->isEnabled()) {
            $canvas->setLineColor($lineStyle->getColor());
            $canvas->setLineThickness($lineStyle->getThickness());
            $canvas->drawEllipse($this->center, $this->width, $this->height);
        }
    }

    public function getFrame(): ?Frame
    {
        if ($this->frame !== null) {
            return $this->frame;
        }

        $left = (int)ceil($this->center->getX() - $this->width / 2);
        $top = (int)ceil($this->center->getY() - $this->height / 2);

        return new Frame(new Point($left, $top), $this->width, $this->height);
    }

    public function setFrame(Frame $frame): void
    {
        $oldFrame = $this->getFrame();
        $this->center = $this->pointTransformationService->transform($this->center, $oldFrame, $frame);
        $this->width = $frame->getWidth();
        $this->height = $frame->getHeight();

        $this->frame = $frame;
    }
}