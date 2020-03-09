<?php
declare(strict_types=1);

namespace Lab08\App;

use Lab08\App\Menu\AboutMenuCommand;
use Lab08\App\Menu\EjectQuarterMenuCommand;
use Lab08\App\Menu\ExitMenuCommand;
use Lab08\App\Menu\HelpMenuCommand;
use Lab08\App\Menu\InsertQuarterMenuCommand;
use Lab08\App\Menu\RefillMenuCommand;
use Lab08\App\Menu\TurnCrankMenuCommand;
use Lab08\Menu\Menu;
use Lab08\Menu\MenuInterface;
use Lab08\Menu\MenuItem;
use Lab08\MultiGumballMachine\Context\GumballMachine;
use Lab08\MultiGumballMachine\Context\GumballMachineInterface;
use SplFileObject;

class App
{
    private const BALLS_COUNT = 100;

    /** @var MenuInterface */
    private $menu;
    /** @var SplFileObject */
    private $stdin;
    /** @var SplFileObject */
    private $stdout;
    /** @var GumballMachineInterface */
    private $gumballMachine;

    public function __construct()
    {
        $this->stdin = new SplFileObject('php://stdin', 'r');
        $this->stdout = new SplFileObject('php://stdout', 'w');
        $this->menu = new Menu($this->stdin, $this->stdout);
        $this->gumballMachine = new GumballMachine($this->stdout, self::BALLS_COUNT);
    }

    public function run(): void
    {
        $this->initMenu();
        $this->menu->run();
    }

    private function initMenu(): void
    {
        $this->menu->addItem(new MenuItem('help', 'Show instructions', new HelpMenuCommand($this->menu)));
        $this->menu->addItem(new MenuItem('exit', 'Exit from program', new ExitMenuCommand($this->menu)));

        $this->menu->addItem(new MenuItem('about', 'About Gumballs machine', new AboutMenuCommand($this->gumballMachine)));
        $this->menu->addItem(new MenuItem('insert', 'Insert quarter', new InsertQuarterMenuCommand($this->gumballMachine)));
        $this->menu->addItem(new MenuItem('eject', 'Eject all quarters', new EjectQuarterMenuCommand($this->gumballMachine)));
        $this->menu->addItem(new MenuItem('turn', 'Release a gumball', new TurnCrankMenuCommand($this->gumballMachine)));
        $this->menu->addItem(new MenuItem('refill', 'refill <count>', new RefillMenuCommand($this->gumballMachine)));
    }
}