<?php
declare(strict_types=1);

namespace Lab08\App\Menu;

use Lab08\Menu\MenuCommandInterface;
use Lab08\Menu\MenuInterface;

class ExitMenuCommand implements MenuCommandInterface
{
    public const SHORTCUT = 'exit';
    public const DESCRIPTION = 'exit from program';

    /** @var MenuInterface */
    private $menu;

    public function __construct(MenuInterface $menu)
    {
        $this->menu = $menu;
    }

    public function execute($arguments): void
    {
        $this->menu->exit();
    }
}