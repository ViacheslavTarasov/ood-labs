<?php
declare(strict_types=1);

namespace Lab08\GumballMachine\State;

class HasQuarterState implements StateInterface
{
    public const INSERT_QUARTER_TEXT = 'You can\'t insert another quarter' . PHP_EOL;
    public const EJECT_QUARTER_TEXT = 'Quarter returned' . PHP_EOL;
    public const TURN_CRANK_TEXT = 'You turned...' . PHP_EOL;
    public const DISPENSE_TEXT = 'No gumball dispensed' . PHP_EOL;
    public const TO_STRING_TEXT = 'waiting for turn of crank' . PHP_EOL;

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
        $this->gumballMachine->setNoQuarterState();
        $this->stdout->fwrite(self::EJECT_QUARTER_TEXT);
    }

    public function turnCrank(): void
    {
        $this->gumballMachine->setSoldState();
        $this->stdout->fwrite(self::TURN_CRANK_TEXT);
    }

    public function dispense(): void
    {
        $this->stdout->fwrite(self::DISPENSE_TEXT);
    }

    public function toString(): string
    {
        return self::TO_STRING_TEXT;
    }
}