<?php
declare(strict_types=1);

namespace Lab05\Document;

interface ImageInterface
{
    public function getPath(): string;

    public function getWidth(): int;

    public function getHeight(): int;

    public function resize(int $width, int $height): void;
}