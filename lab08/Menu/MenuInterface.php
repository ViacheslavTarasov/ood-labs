<?php
declare(strict_types=1);

namespace Lab08\Menu;

interface MenuInterface
{
    public function showInstruction(): void;

    public function exit(): void;
}