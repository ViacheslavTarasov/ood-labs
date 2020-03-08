<?php
declare(strict_types=1);

namespace Lab07\Shape;

use Lab07\Canvas\CanvasInterface;
use Lab07\Style\LineStyleInterface;
use Lab07\Style\StyleInterface;

class Polygon extends Shape
{
    /**
     * @var PointTransformationService
     */
    private $pointTransformationService;
    /** @var Point[] */
    private $vertices;
    /** @var Frame */
    private $frame;

    public function __construct(LineStyleInterface $lineStyle, StyleInterface $fillStyle, array $vertices)
    {
        $this->pointTransformationService = new PointTransformationService();
        $this->setVerticesOrException($vertices);
        parent::__construct($lineStyle, $fillStyle);
    }

    public function draw(CanvasInterface $canvas): void
    {
        $fillStyle = $this->getFillStyle();
        if ($fillStyle->isEnabled()) {
            $canvas->setFillColor($fillStyle->getColor());
            $canvas->drawFilledPolygon($this->vertices);
        }

        $lineStyle = $this->getLineStyle();
        if ($lineStyle->isEnabled()) {
            $canvas->setLineColor($lineStyle->getColor());
            $canvas->setLineThickness($lineStyle->getThickness());
            $canvas->drawPolygon($this->vertices);
        }
    }

    public function getFrame(): ?Frame
    {
        if ($this->frame !== null) {
            return $this->frame;
        }

        $verticesX = $this->getVerticesX();
        $verticesY = $this->getVerticesY();

        $left = min($verticesX);
        $top = min($verticesY);
        $width = max($verticesX) - $left;
        $height = max($verticesY) - $top;

        return new Frame(new Point($left, $top), $width, $height);
    }

    public function setFrame(Frame $frame): void
    {
        $oldFrame = $this->getFrame();
        foreach ($this->vertices as $key => $vertex) {
            $this->vertices[$key] = $this->pointTransformationService->transform($vertex, $oldFrame, $frame);
        }
        $this->frame = $frame;
    }

    private function getVerticesX(): array
    {
        return array_map(function (Point $point) {
            return $point->getX();
        }, $this->vertices);
    }

    private function getVerticesY(): array
    {
        return array_map(function (Point $point) {
            return $point->getY();
        }, $this->vertices);
    }

    private function setVerticesOrException(array $vertices): void
    {
        if (count($vertices) < 3) {
            throw new \InvalidArgumentException('Too few vertices');
        }

        foreach ($vertices as $vertex) {
            if (!$vertex instanceof Point) {
                throw new \LogicException('Expected Point');
            }
            $this->vertices[] = $vertex;
        }
    }
}