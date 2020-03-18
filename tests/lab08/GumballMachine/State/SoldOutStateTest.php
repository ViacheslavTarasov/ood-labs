<?php
declare(strict_types=1);

use Lab08\GumballMachine\Context\PrivateGumballMachineInterface;
use Lab08\GumballMachine\State\SoldOutState;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SoldOutStateTest extends TestCase
{
    /** @var PrivateGumballMachineInterface|MockObject */
    private $gumballMachine;
    /** @var SoldOutState */
    private $soldOutState;
    /** @var SplTempFileObject */
    private $stdout;

    public function testToStringReturnsExpectedString(): void
    {
        $this->assertEquals(SoldOutState::TO_STRING_TEXT, $this->soldOutState->toString());
    }

    public function testInsertQuarterDoesNotAddQuarter(): void
    {
        $this->soldOutState->insertQuarter();
        $this->assertEquals(SoldOutState::INSERT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testEjectQuarterDoesNotEjectQuarter(): void
    {
        $this->soldOutState->ejectQuarter();
        $this->assertEquals(SoldOutState::EJECT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testTurnCrankDoesNotReleaseGumball(): void
    {
        $this->soldOutState->turnCrank();
        $this->assertEquals(SoldOutState::TURN_CRANK_TEXT, $this->getFirstLineFromStdout());
    }

    public function testDispenseIsProhibited(): void
    {
        $this->soldOutState->dispense();
        $this->assertEquals(SoldOutState::DISPENSE_TEXT, $this->getFirstLineFromStdout());
    }

    protected function setUp(): void
    {
        $this->gumballMachine = $this->createMock(PrivateGumballMachineInterface::class);
        $this->stdout = new SplTempFileObject();
        $this->soldOutState = new SoldOutState($this->stdout, $this->gumballMachine);
    }

    private function getFirstLineFromStdout(): string
    {
        $this->stdout->rewind();
        return $this->stdout->fgets();
    }
}
