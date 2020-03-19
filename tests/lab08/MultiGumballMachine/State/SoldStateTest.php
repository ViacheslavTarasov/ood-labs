<?php
declare(strict_types=1);

use Lab08\MultiGumballMachine\State\PrivateGumballMachineInterface;
use Lab08\MultiGumballMachine\State\SoldState;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SoldStateTest extends TestCase
{
    /** @var \Lab08\MultiGumballMachine\State\PrivateGumballMachineInterface|MockObject */
    private $mockGumballMachine;
    /** @var SoldState */
    private $soldState;
    /** @var SplTempFileObject */
    private $stdout;

    public function testToStringReturnsExpectedString(): void
    {
        $this->assertEquals(SoldState::TO_STRING_TEXT, $this->soldState->toString());
    }

    public function testQuarterInsertionIsNotAllowed(): void
    {
        $this->soldState->insertQuarter();
        $this->assertEquals(SoldState::INSERT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testQuarterCantBeEjected(): void
    {
        $this->soldState->ejectQuarter();
        $this->assertEquals(SoldState::EJECT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testTurningCrankDoesNotReleaseGumball(): void
    {
        $this->soldState->turnCrank();
        $this->assertEquals(SoldState::TURN_CRANK_TEXT, $this->getFirstLineFromStdout());
    }

    public function testDispenseReleasesGumball(): void
    {
        $this->mockGumballMachine->expects($this->once())->method('releaseBall');
        $this->soldState->dispense();
    }

    public function testDispenseSetsSoldOutStateAfterSellingLastGumball(): void
    {
        $this->mockGumballMachine->expects($this->once())->method('getBallCount')->willReturn(0);
        $this->mockGumballMachine->expects($this->once())->method('setSoldOutState');
        $this->soldState->dispense();
    }

    public function testDispenseSetsNoQuarterStateWhenGumballsIsAvailable(): void
    {
        $this->mockGumballMachine->expects($this->once())->method('getBallCount')->willReturn(1);
        $this->mockGumballMachine->expects($this->once())->method('setNoQuarterState');
        $this->soldState->dispense();
    }

    public function testRefillDoesNotResetGumballsCount(): void
    {
        $newGumballsCount = 10;
        $this->mockGumballMachine->expects($this->never())->method('setBallCount');
        $this->soldState->refill($newGumballsCount);
        $this->assertEquals(SoldState::REFILL_TEXT, $this->getFirstLineFromStdout());
    }

    protected function setUp(): void
    {
        $this->mockGumballMachine = $this->createMock(PrivateGumballMachineInterface::class);
        $this->stdout = new SplTempFileObject();
        $this->soldState = new SoldState($this->stdout, $this->mockGumballMachine);
    }

    private function getFirstLineFromStdout(): string
    {
        $this->stdout->rewind();
        return $this->stdout->fgets();
    }
}
