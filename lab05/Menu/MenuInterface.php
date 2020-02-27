<?php
declare(strict_types=1);

namespace Lab05\Menu;

interface MenuInterface
{
    public function showInstruction(): void;

    public function exit(): void;
}