<?php
declare(strict_types=1);

namespace Lab08\App\Menu;

use InvalidArgumentException;
use Lab08\Menu\MenuCommandInterface;
use Lab08\MultiGumballMachine\Context\GumballMachineInterface;

class RefillMenuCommand implements MenuCommandInterface
{
    /** @var GumballMachineInterface */
    private $gumballMachine;

    public function __construct(GumballMachineInterface $gumballMachine)
    {
        $this->gumballMachine = $gumballMachine;
    }

    public function execute(string $arguments): void
    {
        preg_match('/^(?<count>\d+)\s*$/', $arguments, $matches);
        $count = $matches['count'] ?? '';
        if (!is_numeric($count)) {
            throw new InvalidArgumentException('invalid command option: count' . PHP_EOL);
        }
        $this->gumballMachine->refill((int)$count);
    }
}