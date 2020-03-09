<?php
declare(strict_types=1);

use Lab08\MultiGumballMachine\Context\PrivateGumballMachine;
use Lab08\MultiGumballMachine\State\SoldOutState;
use PHPUnit\Framework\TestCase;

class PrivateGumballMachineWhenSoldOutStateTest extends TestCase
{
    /** @var PrivateGumballMachine */
    private $emptyGumballMachine;
    /** @var SplTempFileObject */
    private $stdout;

    public function testQuarterNotInserted(): void
    {
        $this->emptyGumballMachine->insertQuarter();
        $this->assertEquals(SoldOutState::INSERT_QUARTER_TEXT, $this->getLineFromStdout());
    }

    public function testQuarterNotEjected(): void
    {
        $this->emptyGumballMachine->ejectQuarter();
        $this->assertEquals(SoldOutState::EJECT_QUARTER_TEXT, $this->getLineFromStdout());
    }

    public function testTurnCrankNotReleasedGumball(): void
    {
        $this->emptyGumballMachine->turnCrank();
        $this->assertEquals(SoldOutState::TURN_CRANK_TEXT, $this->getLineFromStdout());
    }

    public function testRefillChangesGumballsCount(): void
    {
        $newGumballsCount = 123;
        $this->emptyGumballMachine->refill($newGumballsCount);
        $this->assertEquals($newGumballsCount, $this->emptyGumballMachine->getBallCount());
    }

    protected function setUp(): void
    {
        $this->stdout = new SplTempFileObject();
        $this->emptyGumballMachine = new PrivateGumballMachine($this->stdout, 0);
    }

    private function getLineFromStdout(): string
    {
        $this->stdout->rewind();
        return $this->stdout->fgets();
    }
}
