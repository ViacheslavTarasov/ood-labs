<?php
declare(strict_types=1);

namespace Lab07\Shape\Style;

use Lab07\Shape\RgbaColor;

interface StyleInterface
{
    public function isEnabled(): bool;

    public function enable(): void;

    public function disable(): void;

    public function setColor(RgbaColor $color): void;

    public function getColor(): ?RgbaColor;
}