<?php
declare(strict_types=1);

namespace Lab05\Document;

class Image implements ImageInterface
{
    public const MIN_SIZE = 1;
    public const MAX_SIZE = 10000;
    /** @var string */
    private $path;
    /** @var int */
    private $width;
    /** @var int */
    private $height;

    public function __construct(string $path, int $width, int $height)
    {
        $this->path = $path;
        $this->setSize($width, $height);
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

    public function resize(int $width, int $height): void
    {
        $this->setSize($width, $height);
    }

    private function setSize(int $width, int $height): void
    {
        if ($width < self::MIN_SIZE || $width > self::MAX_SIZE) {
            throw new \InvalidArgumentException('invalid width');
        }
        if ($height < self::MIN_SIZE || $height > self::MAX_SIZE) {
            throw new \InvalidArgumentException('invalid width');
        }
        $this->width = $width;
        $this->height = $height;
    }
}