<?php
declare(strict_types=1);

namespace Lab08\GumballMachine\State;

class NoQuarterState implements StateInterface
{
    public const INSERT_QUARTER_TEXT = 'You inserted a quarter' . PHP_EOL;
    public const EJECT_QUARTER_TEXT = 'You haven\'t inserted a quarter' . PHP_EOL;
    public const TURN_CRANK_TEXT = 'You turned but there\'s no quarter' . PHP_EOL;
    public const DISPENSE_TEXT = 'You need to pay first' . PHP_EOL;
    public const TO_STRING_TEXT = 'waiting for quarter' . PHP_EOL;

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
        $this->gumballMachine->setHasQuarterState();
    }

    public function ejectQuarter(): void
    {
        $this->stdout->fwrite(self::EJECT_QUARTER_TEXT);
    }

    public function turnCrank(): void
    {
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