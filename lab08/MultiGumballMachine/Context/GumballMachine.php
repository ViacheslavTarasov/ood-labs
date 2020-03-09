<?php
declare(strict_types=1);

namespace Lab08\MultiGumballMachine\Context;

class GumballMachine implements GumballMachineInterface
{
    /** @var \SplFileObject */
    private $stdout;
    /** @var PrivateGumballMachine */
    private $privateGumballMachine;

    public function __construct(\SplFileObject $stdout, int $count)
    {
        $this->stdout = $stdout;
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
        $this->stdout->fwrite($this->privateGumballMachine->toString());
    }
}