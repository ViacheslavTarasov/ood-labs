<?php
declare(strict_types=1);

namespace Lab08\Menu;

interface MenuCommandInterface
{
    public function execute(string $arguments): void;
}