<?php
declare(strict_types=1);

use Lab08\GumballMachine\State\NoQuarterState;
use Lab08\GumballMachine\State\PrivateGumballMachineInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class NoQuarterStateTest extends TestCase
{
    /** @var \Lab08\GumballMachine\State\PrivateGumballMachineInterface|MockObject */
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
        $this->noQuarterState->insertQuarter();
        $this->assertEquals(NoQuarterState::INSERT_QUARTER_TEXT, $this->getFirstLineFromStdout());
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
