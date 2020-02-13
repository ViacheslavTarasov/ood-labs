<?php
declare(strict_types=1);

namespace Lab05\Command\Menu;

use Lab05\Menu\MenuInterface;

class HelpMenuCommand implements MenuCommandInterface
{
    public const SHORTCUT = 'help';
    public const DESCRIPTION = 'shows instructions';

    /** @var MenuInterface */
    private $menu;

    public function __construct(MenuInterface $menu)
    {
        $this->menu = $menu;
    }

    public function execute(string $arguments): void
    {
        $this->menu->showInstruction();
    }
}