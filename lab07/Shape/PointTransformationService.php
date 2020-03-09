<?php
declare(strict_types=1);

namespace Lab07\Shape;

class PointTransformationService
{
    public static function transform(Point $point, Frame $oldFrame, Frame $newFrame): Point
    {
        $xTransform = $newFrame->getWidth() / $oldFrame->getWidth();
        $newX = $xTransform * ($point->getX() - $oldFrame->getLeftTop()->getX()) + $newFrame->getLeftTop()->getX();
        $yTransform = $newFrame->getHeight() / $oldFrame->getHeight();
        $newY = $yTransform * ($point->getY() - $oldFrame->getLeftTop()->getY()) + $newFrame->getLeftTop()->getY();

        return new Point((int)$newX, (int)$newY);
    }
}