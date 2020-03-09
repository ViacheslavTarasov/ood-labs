<?php
declare(strict_types=1);

use Lab08\MultiGumballMachine\Context\PrivateGumballMachine;
use Lab08\MultiGumballMachine\State\SoldState;
use PHPUnit\Framework\TestCase;

class PrivateGumballMachineWhenSoldStateTest extends TestCase
{
    private const COUNT = 3;

    /** @var PrivateGumballMachine */
    private $gumballMachine;
    /** @var SplTempFileObject */
    private $stdout;

    public function testQuarterNotInserted(): void
    {
        $this->gumballMachine->insertQuarter();
        $this->assertEquals(SoldState::INSERT_QUARTER_TEXT, $this->getLineFromStdout());
    }

    public function testQuarterNotEjectedIfNoQuarters(): void
    {
        $this->gumballMachine->ejectQuarter();
        $this->assertEquals(SoldState::EJECT_QUARTER_TEXT, $this->getLineFromStdout());
    }

    public function testTurnCrankNotReleasedGumball(): void
    {
        $this->gumballMachine->turnCrank();
        $this->assertEquals(SoldState::TURN_CRANK_TEXT, $this->getLineFromStdout());
    }

    public function testRefillDoesNotChangeGumballsCount(): void
    {
        $newGumballsCount = 123;
        $this->gumballMachine->refill($newGumballsCount);
        $this->assertEquals(self::COUNT, $this->gumballMachine->getBallCount());
    }

    protected function setUp(): void
    {
        $this->stdout = new SplTempFileObject();
        $this->gumballMachine = $this->createGumballMachineWithSoldState(self::COUNT);
    }

    private function getLineFromStdout(): string
    {
        $this->stdout->rewind();
        return $this->stdout->fgets();
    }

    private function createGumballMachineWithSoldState(int $count): PrivateGumballMachine
    {
        $gumballMachine = new PrivateGumballMachine($this->stdout, $count);
        $gumballMachine->insertQuarter();
        $gumballMachine->setSoldState();
        $this->stdout->ftruncate(0);
        return $gumballMachine;
    }
}
