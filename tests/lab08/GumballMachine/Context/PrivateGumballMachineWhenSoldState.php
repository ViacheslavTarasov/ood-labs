<?php
declare(strict_types=1);

use Lab08\GumballMachine\Context\PrivateGumballMachine;
use Lab08\GumballMachine\State\SoldState;
use PHPUnit\Framework\TestCase;

class PrivateGumballMachineWhenSoldState extends TestCase
{
    private const COUNT = 3;

    /** @var PrivateGumballMachine */
    private $gumballMachine;
    /** @var SplTempFileObject */
    private $stdout;

    public function testEqualsMessageWhenTurnCrank(): void
    {
        $this->gumballMachine->turnCrank();
        $this->assertEquals(SoldState::TURN_CRANK_TEXT, $this->getFirstLineFromStdout());
    }

    public function testEqualsMessageWhenInsertQuarter(): void
    {
        $this->gumballMachine->insertQuarter();
        $this->assertEquals(SoldState::INSERT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testEqualsMessageWhenEjectQuarter(): void
    {
        $this->gumballMachine->ejectQuarter();
        $this->assertEquals(SoldState::EJECT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    protected function setUp(): void
    {
        $this->stdout = new SplTempFileObject();
        $this->gumballMachine = new PrivateGumballMachine($this->stdout, self::COUNT);
        $this->gumballMachine->setSoldState();
    }

    private function getFirstLineFromStdout(): string
    {
        $this->stdout->rewind();
        return $this->stdout->fgets();
    }
}
