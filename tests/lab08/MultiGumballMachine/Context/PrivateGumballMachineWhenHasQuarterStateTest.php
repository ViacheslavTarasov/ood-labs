<?php
declare(strict_types=1);

use Lab08\MultiGumballMachine\Context\PrivateGumballMachine;
use Lab08\MultiGumballMachine\State\HasQuarterState;
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
        $this->assertEquals(HasQuarterState::TURN_CRANK_TEXT, $this->getLineFromStdout());
    }

    public function testInsertedQuarterNotMoreThenMaxQuarterCountWhenInitiallyNoQuarter(): void
    {
        for ($i = 0; $i < PrivateGumballMachine::MAX_QUARTERS - 1; $i++) {
            $this->gumballMachine->insertQuarter();
            $this->assertEquals(PrivateGumballMachine::INSERT_QUARTER_TEXT, $this->getLineFromStdout());
            $this->clearStdout();
        }
        $this->gumballMachine->insertQuarter();
        $this->assertEquals(HasQuarterState::CANT_INSERT_QUARTER_TEXT, $this->getLineFromStdout());
    }

    public function testQuarterEjected(): void
    {
        $this->gumballMachine->ejectQuarter();
        $this->stdout->rewind();
        $this->assertEquals(PrivateGumballMachine::RETURN_QUARTERS_TEXT . 1 . PHP_EOL, $this->getLineFromStdout());
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
        $this->gumballMachine->insertQuarter();
        $this->stdout->ftruncate(0);
    }

    private function getLineFromStdout(): string
    {
        $this->stdout->rewind();
        return $this->stdout->fgets();
    }

    private function clearStdout(): void
    {
        $this->stdout->ftruncate(0);
    }
}
