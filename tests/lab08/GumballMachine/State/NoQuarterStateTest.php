<?php
declare(strict_types=1);

use Lab08\GumballMachine\Context\PrivateGumballMachineInterface;
use Lab08\GumballMachine\State\NoQuarterState;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class NoQuarterStateTest extends TestCase
{
    /** @var PrivateGumballMachineInterface|MockObject */
    private $gumballMachine;
    /** @var NoQuarterState */
    private $noQuarterState;
    /** @var SplTempFileObject */
    private $stdout;

    public function testToString(): void
    {
        $this->assertEquals(NoQuarterState::TO_STRING_TEXT, $this->noQuarterState->toString());
    }

    public function testCallsSetHasQuarterStateAndWriteInStdoutWhenInsertQuarter(): void
    {
        $this->gumballMachine->expects($this->once())->method('setHasQuarterState');
        $this->noQuarterState->insertQuarter();
        $this->assertEquals(NoQuarterState::INSERT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testEjectQuarterWriteInStdout(): void
    {
        $this->noQuarterState->ejectQuarter();
        $this->assertEquals(NoQuarterState::EJECT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testTurnCrankWriteInStdout(): void
    {
        $this->noQuarterState->turnCrank();
        $this->assertEquals(NoQuarterState::TURN_CRANK_TEXT, $this->getFirstLineFromStdout());
    }

    public function testDispenseWriteInStdout(): void
    {
        $this->noQuarterState->dispense();
        $this->assertEquals(NoQuarterState::DISPENSE_TEXT, $this->getFirstLineFromStdout());
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
