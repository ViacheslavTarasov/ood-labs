<?php
declare(strict_types=1);

namespace Lab07\Style;

use Lab07\Color\RgbaColor;

interface StyleInterface
{
    public function isEnabled(): bool;

    public function enable(): void;

    public function disable(): void;

    public function setColor(RgbaColor $color): void;

    public function getColor(): ?RgbaColor;
}