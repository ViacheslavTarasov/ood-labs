<?php
declare(strict_types=1);

namespace Lab08\MultiGumballMachine\Context;

class GumballMachine implements GumballMachineInterface
{
    /** @var PrivateGumballMachine */
    private $privateGumballMachine;

    public function __construct(\SplFileObject $stdout, int $count)
    {
        $this->privateGumballMachine = new PrivateGumballMachine($stdout, $count);
    }

    public function insertQuarter(): void
    {
        $this->privateGumballMachine->insertQuarter();
    }

    public function ejectQuarter(): void
    {
        $this->privateGumballMachine->ejectQuarter();
    }

    public function turnCrank(): void
    {
        $this->privateGumballMachine->turnCrank();
    }

    public function refill(int $count): void
    {
        $this->privateGumballMachine->refill($count);
    }

    public function about(): void
    {
        $this->privateGumballMachine->about();
    }
}