<?php
declare(strict_types=1);

namespace Lab04\Painter;

use Lab04\Canvas\CanvasInterface;
use Lab04\PictureDraft\PictureDraft;

interface PainterInterface
{
    public function drawPicture(PictureDraft $pictureDraft, CanvasInterface $canvas);
}