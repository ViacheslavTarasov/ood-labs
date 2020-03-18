<?php
declare(strict_types=1);

namespace Lab07\Style;

interface FillStyleIterableInterface
{
    public function iterateFillStyle(\Closure $closure): void;
}