<?php
declare(strict_types=1);

use Lab08\GumballMachine\Context\PrivateGumballMachine;
use Lab08\GumballMachine\State\HasQuarterState;
use PHPUnit\Framework\TestCase;

class PrivateGumballMachineWhenHasQuarterStateTest extends TestCase
{
    private const COUNT = 3;

    /** @var PrivateGumballMachine */
    private $gumballMachine;
    /** @var SplTempFileObject */
    private $stdout;

    public function testGumballWasReleasedWhenTurnCrank(): void
    {
        $this->gumballMachine->turnCrank();
        $this->assertEquals(self::COUNT - 1, $this->gumballMachine->getBallCount());
        $this->assertEquals(HasQuarterState::TURN_CRANK_TEXT, $this->getSecondLineFromStdout());
    }

    public function testEqualsMessageWhenInsertQuarter(): void
    {
        $this->gumballMachine->insertQuarter();
        $this->assertEquals(HasQuarterState::INSERT_QUARTER_TEXT, $this->getSecondLineFromStdout());
    }

    public function testEqualsMessageWhenEjectQuarter(): void
    {
        $this->gumballMachine->ejectQuarter();
        $this->assertEquals(HasQuarterState::EJECT_QUARTER_TEXT, $this->getSecondLineFromStdout());
    }

    protected function setUp(): void
    {
        $this->stdout = new SplTempFileObject();
        $this->gumballMachine = new PrivateGumballMachine($this->stdout, self::COUNT);
        $this->gumballMachine->insertQuarter();
    }

    private function getSecondLineFromStdout(): string
    {
        $this->stdout->rewind();
        $this->stdout->fgets();
        return $this->stdout->fgets();
    }
}
