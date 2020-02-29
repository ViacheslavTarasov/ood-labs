<?php
declare(strict_types=1);

namespace Lab05\Document\Command;

class ResizeImageCommand extends AbstractCommand
{
    /** @var int */
    private $width;
    /** @var int */
    private $height;
    /** @var int */
    private $newWidth;
    /** @var int */
    private $newHeight;

    public function __construct(int &$width, int &$height, int $newWidth, int $newHeight)
    {
        $this->width = &$width;
        $this->height = &$height;
        $this->newWidth = $newWidth;
        $this->newHeight = $newHeight;
    }

    protected function doExecute(): void
    {
        $this->resize();
    }

    protected function doUnexecute(): void
    {
        $this->resize();
    }

    private function resize(): void
    {
        [$this->width, $this->newWidth] = [$this->newWidth, $this->width];
        [$this->height, $this->newHeight] = [$this->newHeight, $this->height];
    }
}