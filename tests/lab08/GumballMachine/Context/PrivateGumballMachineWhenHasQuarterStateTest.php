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
        $this->assertEquals(HasQuarterState::TURN_CRANK_TEXT, $this->getLineFromStdout());
    }

    public function testQuarterNotInserted(): void
    {
        $this->gumballMachine->insertQuarter();
        $this->assertEquals(HasQuarterState::INSERT_QUARTER_TEXT, $this->getLineFromStdout());
    }

    public function testQuarterEjected(): void
    {
        $this->gumballMachine->ejectQuarter();
        $this->assertEquals(HasQuarterState::EJECT_QUARTER_TEXT, $this->getLineFromStdout());
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
}
