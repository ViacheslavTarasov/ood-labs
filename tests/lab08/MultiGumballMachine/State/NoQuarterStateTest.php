<?php
declare(strict_types=1);

use Lab08\MultiGumballMachine\State\NoQuarterState;
use Lab08\MultiGumballMachine\State\PrivateGumballMachineInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class NoQuarterStateTest extends TestCase
{
    /** @var \Lab08\MultiGumballMachine\State\PrivateGumballMachineInterface|MockObject */
    private $gumballMachine;
    /** @var NoQuarterState */
    private $noQuarterState;
    /** @var SplTempFileObject */
    private $stdout;

    public function testToStringReturnsExpectedString(): void
    {
        $this->assertEquals(NoQuarterState::TO_STRING_TEXT, $this->noQuarterState->toString());
    }

    public function testInsertQuarterSetHasQuarterStateAndAddsQuarter(): void
    {
        $this->gumballMachine->expects($this->once())->method('setHasQuarterState');
        $this->gumballMachine->expects($this->once())->method('addQuarter');
        $this->noQuarterState->insertQuarter();
    }

    public function testQuarterCantBeEjected(): void
    {
        $this->noQuarterState->ejectQuarter();
        $this->assertEquals(NoQuarterState::EJECT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testTurningCrankHasNoEffect(): void
    {
        $this->noQuarterState->turnCrank();
        $this->assertEquals(NoQuarterState::TURN_CRANK_TEXT, $this->getFirstLineFromStdout());
    }

    public function testDispenseIsProhibited(): void
    {
        $this->noQuarterState->dispense();
        $this->assertEquals(NoQuarterState::DISPENSE_TEXT, $this->getFirstLineFromStdout());
    }

    public function testRefillResetsGumballsCount(): void
    {
        $newGumballsCount = 10;
        $this->gumballMachine->expects($this->once())->method('setBallCount')->with($newGumballsCount);
        $this->noQuarterState->refill($newGumballsCount);
    }

    public function testRefillSetSoldOutStateIfNewGumballsCountIsZero(): void
    {
        $newGumballsCount = 0;
        $this->gumballMachine->method('getBallCount')->willReturn($newGumballsCount);
        $this->gumballMachine->expects($this->once())->method('setSoldOutState');
        $this->noQuarterState->refill($newGumballsCount);
    }

    public function testRefillDoesNotSetsSoldOutStateIfNewGumballsCountMoreThanZero(): void
    {
        $newGumballsCount = 1;
        $this->gumballMachine->method('getBallCount')->willReturn($newGumballsCount);
        $this->gumballMachine->expects($this->never())->method('setSoldOutState');
        $this->noQuarterState->refill($newGumballsCount);
    }

    protected function setUp(): void
    {
        $this->gumballMachine = $this->createMock(PrivateGumballMachineInterface::class);
        $this->stdout = new SplTempFileObject();
        $this->noQuarterState = new NoQuarterState($this->stdout, $this->gumballMachine);
    }

    private function getFirstLineFromStdout(): string
    {
        $this->stdout->rewind();
        return $this->stdout->fgets();
    }
}
