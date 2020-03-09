<?php
declare(strict_types=1);

use Lab08\MultiGumballMachine\Context\PrivateGumballMachine;
use Lab08\MultiGumballMachine\State\NoQuarterState;
use PHPUnit\Framework\TestCase;

class PrivateGumballMachineWhenNoQuarterStateTest extends TestCase
{
    private const COUNT = 3;

    /** @var PrivateGumballMachine */
    private $gumballMachine;
    /** @var SplTempFileObject */
    private $stdout;

    public function testQuarterInserted(): void
    {
        $this->gumballMachine->insertQuarter();
        $this->assertEquals(NoQuarterState::INSERT_QUARTER_TEXT, $this->getLineFromStdout());
    }

    public function testQuarterNotEjected(): void
    {
        $this->gumballMachine->ejectQuarter();
        $this->assertEquals(NoQuarterState::EJECT_QUARTER_TEXT, $this->getLineFromStdout());
    }

    public function testGumballNotReleasedWhenTurnCrank(): void
    {
        $this->gumballMachine->turnCrank();
        $this->assertEquals(self::COUNT, $this->gumballMachine->getBallCount());
        $this->assertEquals(NoQuarterState::TURN_CRANK_TEXT, $this->getLineFromStdout());
    }

    public function testRefillChangesGumballsCount(): void
    {
        $newGumballsCount = 123;
        $this->gumballMachine->refill($newGumballsCount);
        $this->assertEquals($newGumballsCount, $this->gumballMachine->getBallCount());
    }

    protected function setUp(): void
    {
        $this->stdout = new SplTempFileObject();
        $this->gumballMachine = new PrivateGumballMachine($this->stdout, self::COUNT);
    }

    private function getLineFromStdout(): string
    {
        $this->stdout->rewind();
        return $this->stdout->fgets();
    }
}
