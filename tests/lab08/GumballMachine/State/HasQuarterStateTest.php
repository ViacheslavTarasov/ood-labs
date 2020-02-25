<?php
declare(strict_types=1);

use Lab08\GumballMachine\Context\PrivateGumballMachineInterface;
use Lab08\GumballMachine\State\HasQuarterState;
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

    public function testToString(): void
    {
        $this->assertEquals(HasQuarterState::TO_STRING_TEXT, $this->hasQuarterState->toString());
    }

    public function testInsertQuarterWriteInStdout(): void
    {
        $this->hasQuarterState->insertQuarter();
        $this->assertEquals(HasQuarterState::INSERT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testCallsSetNoQuarterStateAndWriteInStdoutWhenEjectQuarter(): void
    {
        $this->gumballMachine->expects($this->once())->method('setNoQuarterState');
        $this->hasQuarterState->ejectQuarter();
        $this->assertEquals(HasQuarterState::EJECT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testCallsSetSoldStateAndWriteInStdoutWhenEjectQuarter(): void
    {
        $this->gumballMachine->expects($this->once())->method('setSoldState');
        $this->hasQuarterState->turnCrank();
        $this->assertEquals(HasQuarterState::TURN_CRANK_TEXT, $this->getFirstLineFromStdout());
    }

    public function testDispenseWriteInStdout(): void
    {
        $this->hasQuarterState->dispense();
        $this->assertEquals(HasQuarterState::DISPENSE_TEXT, $this->getFirstLineFromStdout());
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
