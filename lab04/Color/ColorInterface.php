<?php
declare(strict_types=1);

namespace Lab04\Color;

interface ColorInterface
{
    public function getR(): int;

    public function getG(): int;

    public function getB(): int;
}