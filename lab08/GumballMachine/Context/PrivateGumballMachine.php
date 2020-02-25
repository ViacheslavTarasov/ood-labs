<?php
declare(strict_types=1);

namespace Lab08\GumballMachine\Context;

use InvalidArgumentException;
use Lab08\GumballMachine\State\HasQuarterState;
use Lab08\GumballMachine\State\NoQuarterState;
use Lab08\GumballMachine\State\SoldOutState;
use Lab08\GumballMachine\State\SoldState;
use Lab08\GumballMachine\State\StateInterface;

class PrivateGumballMachine implements PrivateGumballMachineInterface
{
    public const RELEASE_TEXT = 'A gumball comes rolling out the slot' . PHP_EOL;

    /** @var \SplFileObject */
    private $stdout;
    /** @var int */
    private $count;
    /** @var StateInterface */
    private $soldOutState;
    /** @var StateInterface */
    private $noQuarterState;
    /** @var StateInterface */
    private $hasQuarterState;
    /** @var StateInterface */
    private $soldState;
    /** @var StateInterface */
    private $currentState;

    public function __construct(\SplFileObject $stdout, int $count)
    {
        if ($count < 0) {
            throw new InvalidArgumentException('invalid count gumballs');
        }

        $this->stdout = $stdout;
        $this->count = $count;

        $this->soldOutState = new SoldOutState($this->stdout, $this);
        $this->noQuarterState = new NoQuarterState($this->stdout, $this);
        $this->hasQuarterState = new HasQuarterState($this->stdout, $this);
        $this->soldState = new SoldState($this->stdout, $this);

        $this->currentState = $this->count ? $this->noQuarterState : $this->soldOutState;
    }

    public function setSoldOutState(): void
    {
        $this->currentState = $this->soldOutState;
    }

    public function setNoQuarterState(): void
    {
        $this->currentState = $this->noQuarterState;
    }

    public function setSoldState(): void
    {
        $this->currentState = $this->soldState;
    }

    public function setHasQuarterState(): void
    {
        $this->currentState = $this->hasQuarterState;
    }

    public function insertQuarter(): void
    {
        $this->currentState->insertQuarter();
    }

    public function ejectQuarter(): void
    {
        $this->currentState->ejectQuarter();
    }

    public function turnCrank(): void
    {
        $this->currentState->turnCrank();
        $this->currentState->dispense();
    }

    public function releaseBall(): void
    {
        if ($this->count) {
            $this->stdout->fwrite(self::RELEASE_TEXT);
            $this->count--;
        }
    }

    public function getBallCount(): int
    {
        return $this->count;
    }
}