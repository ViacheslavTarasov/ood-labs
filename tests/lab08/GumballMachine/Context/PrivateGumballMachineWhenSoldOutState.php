<?php
declare(strict_types=1);

use Lab08\GumballMachine\Context\PrivateGumballMachine;
use Lab08\GumballMachine\State\SoldOutState;
use PHPUnit\Framework\TestCase;

class PrivateGumballMachineWhenSoldOutState extends TestCase
{
    /** @var PrivateGumballMachine */
    private $emptyGumballMachine;
    /** @var SplTempFileObject */
    private $stdout;

    public function testEqualsMessageWhenTurnCrank(): void
    {
        $this->emptyGumballMachine->turnCrank();
        $this->assertEquals(SoldOutState::TURN_CRANK_TEXT, $this->getFirstLineFromStdout());
    }

    public function testEqualsMessageWhenInsertQuarter(): void
    {
        $this->emptyGumballMachine->insertQuarter();
        $this->assertEquals(SoldOutState::INSERT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testEqualsMessageWhenEjectQuarter(): void
    {
        $this->emptyGumballMachine->ejectQuarter();
        $this->assertEquals(SoldOutState::EJECT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    protected function setUp(): void
    {
        $this->stdout = new SplTempFileObject();
        $this->emptyGumballMachine = new PrivateGumballMachine($this->stdout, 0);
    }

    private function getFirstLineFromStdout(): string
    {
        $this->stdout->rewind();
        return $this->stdout->fgets();
    }
}
