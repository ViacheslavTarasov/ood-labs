<?php
declare(strict_types=1);

use Lab08\GumballMachine\Context\PrivateGumballMachineInterface;
use Lab08\GumballMachine\State\SoldState;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SoldStateTest extends TestCase
{
    /** @var PrivateGumballMachineInterface|MockObject */
    private $mockGumballMachine;
    /** @var SoldState */
    private $soldState;
    /** @var SplTempFileObject */
    private $stdout;

    public function testToString(): void
    {
        $this->assertEquals(SoldState::TO_STRING_TEXT, $this->soldState->toString());
    }

    public function testInsertQuarterWriteInStdout(): void
    {
        $this->soldState->insertQuarter();
        $this->assertEquals(SoldState::INSERT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testEjectQuarterWriteInStdout(): void
    {
        $this->soldState->ejectQuarter();
        $this->assertEquals(SoldState::EJECT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testTurnCrankWriteInStdout(): void
    {
        $this->soldState->turnCrank();
        $this->assertEquals(SoldState::TURN_CRANK_TEXT, $this->getFirstLineFromStdout());
    }

    public function testCallsReleaseBallWhenDispense(): void
    {
        $this->mockGumballMachine->expects($this->once())->method('releaseBall');
        $this->soldState->dispense();
    }

    public function testDispenseSetsSoldOutStateWhenSoldLastGumball(): void
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
