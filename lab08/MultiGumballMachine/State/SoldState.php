<?php
declare(strict_types=1);

namespace Lab08\MultiGumballMachine\State;

use Lab08\MultiGumballMachine\Context\PrivateGumballMachineInterface;

class SoldState implements StateInterface
{
    public const INSERT_QUARTER_TEXT = 'Please wait, we\'re already giving you a gumball' . PHP_EOL;
    public const EJECT_QUARTER_TEXT = 'Sorry you already turned the crank' . PHP_EOL;
    public const TURN_CRANK_TEXT = 'Turning twice doesn\'t get you another gumball' . PHP_EOL;
    public const OUT_OFF_GUMBALLS = 'Oops, out of gumballs' . PHP_EOL;
    public const TO_STRING_TEXT = 'delivering a gumball' . PHP_EOL;
    public const REFILL_TEXT = 'Please wait, refill unavailable while the machine gumball release' . PHP_EOL;

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
        $this->stdout->fwrite(self::EJECT_QUARTER_TEXT);
    }

    public function turnCrank(): void
    {
        $this->stdout->fwrite(self::TURN_CRANK_TEXT);
    }

    public function dispense(): void
    {
        $this->gumballMachine->releaseBall();
        if ($this->gumballMachine->getBallCount() === 0) {
            $this->gumballMachine->setSoldOutState();
            $this->stdout->fwrite(self::OUT_OFF_GUMBALLS);
        } elseif ($this->gumballMachine->getQuarterCount() > 0) {
            $this->gumballMachine->setHasQuarterState();
        } else {
            $this->gumballMachine->setNoQuarterState();
        }
    }

    public function refill(int $count): void
    {
        $this->stdout->fwrite(self::REFILL_TEXT);
    }

    public function toString(): string
    {
        return self::TO_STRING_TEXT;
    }
}