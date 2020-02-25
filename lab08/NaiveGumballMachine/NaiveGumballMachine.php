<?php
declare(strict_types=1);

namespace Lab08\MultiGumballMachine\Context;

class NaiveGumballMachine
{
    public const MAX_QUARTERS = 5;

    /** @var \SplFileObject */
    private $stdout;
    /** @var int */
    private $count;
    /** @var string */
    private $state;
    private $quarters;

    public function __construct(\SplFileObject $stdout, int $count)
    {
        $this->stdout = $stdout;
        $this->count = $count;
        $this->state = $this->count ? State::NO_QUARTER : State::SOLD_OUT;
    }

    public function insertQuarter(): void
    {
        switch ($this->state) {
            case State::SOLD_OUT:
                $this->stdout->fwrite("You can't insert a quarter, the machine is sold out" . PHP_EOL);
                break;
            case State::NO_QUARTER:
            case State::HAS_QUARTER:
                $this->addQuarter();
                $this->state = State::HAS_QUARTER;
                break;
            case State::SOLD:
                $this->stdout->fwrite("Please wait, we're already giving you a gumball" . PHP_EOL);
                break;
        }
    }

    public function ejectQuarter(): void
    {
        switch ($this->state) {
            case State::HAS_QUARTER:
                $this->ejectAllQuarters();
                $this->state = State::NO_QUARTER;
                break;
            case State::NO_QUARTER:
                $this->stdout->fwrite("You haven't inserted a quarter" . PHP_EOL);
                break;
            case State::SOLD:
                $this->stdout->fwrite("Sorry you already turned the crank" . PHP_EOL);
                break;
            case State::SOLD_OUT:
                if ($this->quarters) {
                    $this->ejectAllQuarters();
                } else {
                    $this->stdout->fwrite("You can't eject, you haven't inserted a quarter yet" . PHP_EOL);
                }
                break;
        }
    }

    public function turnCrank(): void
    {
        switch ($this->state) {
            case State::SOLD_OUT:
                $this->stdout->fwrite("You turned but there's no gumballs" . PHP_EOL);
                break;
            case State::NO_QUARTER:
                $this->stdout->fwrite("You turned but there's no quarter" . PHP_EOL);
                break;
            case State::HAS_QUARTER:
                $this->stdout->fwrite("You turned..." . PHP_EOL);
                $this->state = State::SOLD;
                $this->dispense();
                break;
            case State::SOLD:
                $this->stdout->fwrite("Turning twice doesn't get you another gumball" . PHP_EOL);
                break;
        }
    }

    public function dispense(): void
    {
        switch ($this->state) {
            case State::SOLD_OUT:
            case State::HAS_QUARTER:
                $this->stdout->fwrite("No gumball dispensed" . PHP_EOL);
                break;
            case State::NO_QUARTER:
                $this->stdout->fwrite("You turned but there's no quarter" . PHP_EOL);
                break;
            case State::SOLD:
                $this->stdout->fwrite("A gumball comes rolling out the slot" . PHP_EOL);
                $this->count--;
                if ($this->count === 0) {
                    $this->stdout->fwrite("Oops, out of gumballs" . PHP_EOL);
                    $this->state = State::SOLD_OUT;
                } else {
                    $this->state = $this->quarters ? State::HAS_QUARTER : State::NO_QUARTER;
                }
                break;
        }
    }

    public function refill(int $count): void
    {
        $this->count += $count;
        if (!$this->count) {
            $this->state = State::SOLD_OUT;
        }
    }

    private function addQuarter(): void
    {
        if ($this->quarters < self::MAX_QUARTERS) {
            $this->quarters++;
            $this->stdout->fwrite("You inserted a quarter" . PHP_EOL);
        } else {
            $this->stdout->fwrite("You can't insert a quarter, max quarters count reached" . PHP_EOL);
        }
    }

    private function ejectAllQuarters(): void
    {
        $this->stdout->fwrite("Quarters returned" . $this->quarters . PHP_EOL);
        $this->quarters = 0;
    }

}