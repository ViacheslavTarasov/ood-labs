<?php
declare(strict_types=1);

namespace Lab08\App\Menu;

use Lab08\Menu\MenuCommandInterface;
use Lab08\MultiGumballMachine\Context\GumballMachineInterface;

class InsertQuarterMenuCommand implements MenuCommandInterface
{
    /** @var GumballMachineInterface */
    private $gumballMachine;

    public function __construct(GumballMachineInterface $gumballMachine)
    {
        $this->gumballMachine = $gumballMachine;
    }

    public function execute(string $arguments): void
    {
        $this->gumballMachine->insertQuarter();
    }
}