<?php
declare(strict_types=1);

use Lab08\MultiGumballMachine\State\HasQuarterState;
use Lab08\MultiGumballMachine\State\PrivateGumballMachineInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class HasQuarterStateTest extends TestCase
{
    /** @var PrivateGumballMachineInterface|MockObject */
    private $gumballMachine;
    /** @var HasQuarterState */
    private $hasQuarterState;
    /** @var SplTempFileObject */
    private $stdout;

    public function testToStringReturnsExpectedString(): void
    {
        $this->assertEquals(HasQuarterState::TO_STRING_TEXT, $this->hasQuarterState->toString());
    }

    public function testQuarterCanBeInsertedIdQuarterCountLessThanMaxQuarters(): void
    {
        $this->gumballMachine->method('isMaxQuarterCountReached')->willReturn(false);
        $this->gumballMachine->expects($this->once())->method('addQuarter');
        $this->hasQuarterState->insertQuarter();
    }

    public function testQuarterCantBeInsertedWhenMaxQuartersCountReached(): void
    {
        $this->gumballMachine->method('isMaxQuarterCountReached')->willReturn(true);
        $this->gumballMachine->expects($this->never())->method('addQuarter');
        $this->hasQuarterState->insertQuarter();
        $this->assertEquals(HasQuarterState::CANT_INSERT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testEjectQuarterReturnsQuarterAndSetsNoQuarterState(): void
    {
        $this->gumballMachine->expects($this->once())->method('returnQuartersCount');
        $this->gumballMachine->expects($this->once())->method('setNoQuarterState');
        $this->hasQuarterState->ejectQuarter();
    }

    public function testTurnCrankSetsSoldAndSaysTurned(): void
    {
        $this->gumballMachine->expects($this->once())->method('setSoldState');
        $this->hasQuarterState->turnCrank();
        $this->assertEquals(HasQuarterState::TURN_CRANK_TEXT, $this->getFirstLineFromStdout());
    }

    public function testDispenseIsProhibited(): void
    {
        $this->hasQuarterState->dispense();
        $this->assertEquals(HasQuarterState::DISPENSE_TEXT, $this->getFirstLineFromStdout());
    }

    public function testRefillResetsGumballsCount(): void
    {
        $newGumballsCount = 10;
        $this->gumballMachine->expects($this->once())->method('setBallCount')->with($newGumballsCount);
        $this->hasQuarterState->refill($newGumballsCount);
    }

    public function testRefillSetSoldOutStateIfNewGumballsCountIsZero(): void
    {
        $newGumballsCount = 0;
        $this->gumballMachine->method('getBallCount')->willReturn($newGumballsCount);
        $this->gumballMachine->expects($this->once())->method('setSoldOutState');
        $this->hasQuarterState->refill($newGumballsCount);
    }

    public function testRefillDoesNotSetsSoldOutStateIfNewGumballsCountMoreThanZero(): void
    {
        $newGumballsCount = 1;
        $this->gumballMachine->method('getBallCount')->willReturn($newGumballsCount);
        $this->gumballMachine->expects($this->never())->method('setSoldOutState');
        $this->hasQuarterState->refill($newGumballsCount);
    }

    protected function setUp(): void
    {
        $this->gumballMachine = $this->createMock(PrivateGumballMachineInterface::class);
        $this->stdout = new SplTempFileObject();
        $this->hasQuarterState = new HasQuarterState($this->stdout, $this->gumballMachine);
    }

    private function getFirstLineFromStdout(): string
    {
        $this->stdout->rewind();
        return $this->stdout->fgets();
    }
}
