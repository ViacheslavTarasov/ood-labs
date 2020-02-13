<?php
declare(strict_types=1);

namespace Lab05\Menu;

interface MenuInterface
{

    public function addItem(MenuItem $menuItem): void;

    public function showInstruction(): void;

    public function run(): void;

    public function exit(): void;
}