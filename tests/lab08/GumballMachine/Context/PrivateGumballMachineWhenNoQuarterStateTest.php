<?php
declare(strict_types=1);

use Lab08\GumballMachine\Context\PrivateGumballMachine;
use Lab08\GumballMachine\State\NoQuarterState;
use PHPUnit\Framework\TestCase;

class PrivateGumballMachineWhenNoQuarterStateTest extends TestCase
{
    private const COUNT = 3;

    /** @var PrivateGumballMachine */
    private $gumballMachine;
    /** @var SplTempFileObject */
    private $stdout;

    public function testGumballNotReleasedWhenTurnCrank(): void
    {
        $this->gumballMachine->turnCrank();
        $this->assertEquals(self::COUNT, $this->gumballMachine->getBallCount());
        $this->assertEquals(NoQuarterState::TURN_CRANK_TEXT, $this->getFirstLineFromStdout());
    }

    public function testEqualsMessageWhenInsertQuarter(): void
    {
        $this->gumballMachine->insertQuarter();
        $this->assertEquals(NoQuarterState::INSERT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testEqualsMessageWhenEjectQuarter(): void
    {
        $this->gumballMachine->ejectQuarter();
        $this->assertEquals(NoQuarterState::EJECT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    protected function setUp(): void
    {
        $this->stdout = new SplTempFileObject();
        $this->gumballMachine = new PrivateGumballMachine($this->stdout, self::COUNT);
    }

    private function getFirstLineFromStdout(): string
    {
        $this->stdout->rewind();
        return $this->stdout->fgets();
    }
}
