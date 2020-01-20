<?php
declare(strict_types=1);

namespace Lab04\Color;

interface ColorFactoryInterface
{
    public function create(string $name): ColorInterface;
}