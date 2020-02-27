<?php
declare(strict_types=1);

namespace Lab05\Service\Input;

class ImageInput
{
    /** @var string */
    private $path;
    /** @var int */
    private $width;
    /** @var int */
    private $height;

    public function __construct(string $path, int $width, int $height)
    {
        $this->path = $path;
        $this->width = $width;
        $this->height = $height;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }
}