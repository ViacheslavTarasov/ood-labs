<?php
declare(strict_types=1);

namespace Lab07\Style;

interface LineStyleIterable
{
    public function iterateLineStyle(\Closure $closure): void;
}