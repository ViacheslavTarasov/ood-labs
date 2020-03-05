<?php
declare(strict_types=1);

namespace Lab07\Shape\Style;

interface LineStyleInterface extends StyleInterface
{
    public function setThickness(int $thickness): void;

    public function getThickness(): ?int;
}