<?php
declare(strict_types=1);

namespace Lab08\MultiGumballMachine\Context;

use InvalidArgumentException;
use Lab08\MultiGumballMachine\State\HasQuarterState;
use Lab08\MultiGumballMachine\State\NoQuarterState;
use Lab08\MultiGumballMachine\State\PrivateGumballMachineInterface;
use Lab08\MultiGumballMachine\State\SoldOutState;
use Lab08\MultiGumballMachine\State\SoldState;
use Lab08\MultiGumballMachine\State\StateInterface;

class PrivateGumballMachine implements PrivateGumballMachineInterface, GumballMachineInterface
{
    public const MAX_QUARTERS = 5;
    public const RELEASE_TEXT = 'A gumball comes rolling out the slot' . PHP_EOL;
    public const INSERT_QUARTER_TEXT = 'You inserted a quarter' . PHP_EOL;
    public const RETURN_QUARTERS_TEXT = 'Quarters returned: ';
    public const TO_STRING_TEMPLATE =
        'Mighty Gumball, Inc.' . PHP_EOL .
        'Inventory: %d gumball%s' . PHP_EOL .
        'Quarters into: %d' . PHP_EOL .
        'Machine is %s';

    /** @var \SplFileObject */
    private $stdout;
    /** @var int */
    private $gumballsCount;
    /** @var int */
    private $quartersCount;
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
        $this->gumballsCount = $count;
        $this->quartersCount = 0;

        $this->soldOutState = new SoldOutState($this->stdout, $this);
        $this->noQuarterState = new NoQuarterState($this->stdout, $this);
        $this->hasQuarterState = new HasQuarterState($this->stdout, $this);
        $this->soldState = new SoldState($this->stdout, $this);

        $this->currentState = $this->gumballsCount ? $this->noQuarterState : $this->soldOutState;
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
        if ($this->gumballsCount) {
            $this->stdout->fwrite(self::RELEASE_TEXT);
            $this->gumballsCount--;
            $this->quartersCount--;
        }
    }

    public function getBallCount(): int
    {
        return $this->gumballsCount;
    }

    public function addQuarter(): void
    {
        if ($this->isMaxQuarterCountReached()) {
            throw new \RuntimeException('Max quarters count has been reached');
        }
        $this->quartersCount++;
        $this->stdout->fwrite(self::INSERT_QUARTER_TEXT);
    }

    public function isMaxQuarterCountReached(): bool
    {
        return self::MAX_QUARTERS <= $this->quartersCount;
    }

    public function getQuarterCount(): int
    {
        return $this->quartersCount;
    }

    public function returnQuartersCount(): void
    {
        $this->stdout->fwrite(self::RETURN_QUARTERS_TEXT . $this->quartersCount . PHP_EOL);
        $this->quartersCount = 0;
    }

    public function refill(int $count): void
    {
        if ($count < 0) {
            throw new \InvalidArgumentException('invalid gumballs count');
        }
        $this->currentState->refill($count);
    }

    public function setBallCount(int $count): void
    {
        $this->gumballsCount = $count;
    }

    public function toString(): string
    {
        return sprintf(self::TO_STRING_TEMPLATE,
            $this->gumballsCount,
            $this->gumballsCount ? 's' : '',
            $this->quartersCount,
            $this->currentState->toString()
        );
    }

    public function about(): void
    {
        $this->stdout->fwrite($this->toString());
    }
}