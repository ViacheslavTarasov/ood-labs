<?php
declare(strict_types=1);

namespace Lab08\MultiGumballMachine\State;

class SoldOutState implements StateInterface
{
    public const INSERT_QUARTER_TEXT = 'You can\'t insert a quarter, the machine is sold out' . PHP_EOL;
    public const EJECT_QUARTER_TEXT = 'You can\'t eject, you haven\'t inserted a quarter yet' . PHP_EOL;
    public const TURN_CRANK_TEXT = 'You turned but there\'s no gumballs' . PHP_EOL;
    public const DISPENSE_TEXT = 'No gumball dispensed' . PHP_EOL;
    public const TO_STRING_TEXT = 'sold out' . PHP_EOL;

    /** @var \SplFileObject */
    private $stdout;
    /** @var PrivateGumballMachineInterface */
    private $gumballMachine;

    public function __construct(\SplFileObject $stdout, PrivateGumballMachineInterface $gumballMachine)
    {
        $this->stdout = $stdout;
        $this->gumballMachine = $gumballMachine;
    }

    public function insertQuarter(): void
    {
        $this->stdout->fwrite(self::INSERT_QUARTER_TEXT);
    }

    public function ejectQuarter(): void
    {
        if ($this->gumballMachine->getQuarterCount()) {
            $this->gumballMachine->returnQuartersCount();
        } else {
            $this->stdout->fwrite(self::EJECT_QUARTER_TEXT);
        }
    }

    public function turnCrank(): void
    {
        $this->stdout->fwrite(self::TURN_CRANK_TEXT);
    }

    public function dispense(): void
    {
        $this->stdout->fwrite(self::DISPENSE_TEXT);
    }

    public function refill(int $count): void
    {
        $this->gumballMachine->setBallCount($count);
        if ($this->gumballMachine->getBallCount() === 0) {
            return;
        }
        if ($this->gumballMachine->getQuarterCount() > 0) {
            $this->gumballMachine->setHasQuarterState();
        } else {
            $this->gumballMachine->setNoQuarterState();
        }
    }

    public function toString(): string
    {
        return self::TO_STRING_TEXT;
    }
}