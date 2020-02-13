<?php
declare(strict_types=1);

namespace Lab05\Command\Menu;

interface MenuCommandInterface
{
    public function execute(string $arguments): void;
}