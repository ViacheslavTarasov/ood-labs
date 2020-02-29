<?php
declare(strict_types=1);

namespace Lab05\Document\Command;

use Lab05\Document\ImageInterface;

class ResizeImageCommand extends AbstractCommand
{
    /** @var ImageInterface */
    private $image;
    /** @var int */
    private $width;
    /** @var int */
    private $height;

    public function __construct(ImageInterface $image, int $width, int $height)
    {
        $this->image = $image;
        $this->width = $width;
        $this->height = $height;
    }

    protected function doExecute(): void
    {
        $this->resize();
    }

    private function resize(): void
    {
        $tmpWidth = $this->image->getWidth();
        $tmpHeight = $this->image->getHeight();
        $this->image->resize($this->width, $this->height);
        $this->width = $tmpWidth;
        $this->height = $tmpHeight;
    }

    protected function doUnexecute(): void
    {
        $this->resize();
    }
}