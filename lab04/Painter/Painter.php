<?php
declare(strict_types=1);

namespace Lab04\Painter;

use Lab04\Canvas\CanvasInterface;
use Lab04\PictureDraft\PictureDraft;

class Painter implements PainterInterface
{

    public function drawPicture(PictureDraft $pictureDraft, CanvasInterface $canvas): void
    {
        $count = $pictureDraft->getShapeCount();
        for ($i = 0; $i < $count; $i++) {
            $shape = $pictureDraft->getShape($i);
            $shape->draw($canvas);
        }
    }

}