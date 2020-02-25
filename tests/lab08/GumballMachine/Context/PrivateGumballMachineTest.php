<?php
declare(strict_types=1);

use Lab08\GumballMachine\Context\PrivateGumballMachine;
use Lab08\GumballMachine\State\HasQuarterState;
use Lab08\GumballMachine\State\NoQuarterState;
use PHPUnit\Framework\TestCase;

class PrivateGumballMachineTest extends TestCase
{
    private const COUNT = 3;

    /** @var PrivateGumballMachine */
    private $gumballMachine;
    /** @var PrivateGumballMachine */
    private $emptyGumballMachine;
    /** @var SplTempFileObject */
    private $stdout;

    public function testThrowsExceptionWhenInstantiateMachineWithNegativeBallsCount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new PrivateGumballMachine($this->stdout, -1);
    }

    public function testGetCountBallsEqualsInitCount(): void
    {
        $this->assertEquals(self::COUNT, $this->gumballMachine->getBallCount());
    }

    public function testCountBallsDecreasesAndWriteInStdoutWhenReleaseBall(): void
    {
        $this->gumballMachine->releaseBall();
        $this->assertEquals(self::COUNT - 1, $this->gumballMachine->getBallCount());

        $this->gumballMachine->releaseBall();
        $this->assertEquals(self::COUNT - 2, $this->gumballMachine->getBallCount());

        $this->stdout->rewind();
        $this->assertEquals(PrivateGumballMachine::RELEASE_TEXT, $this->stdout->fgets());
        $this->assertEquals(PrivateGumballMachine::RELEASE_TEXT, $this->stdout->fgets());
    }

    public function testCountGumballsDoNotDecreasesWhenReleaseIfNoGumballs(): void
    {
        $this->emptyGumballMachine->releaseBall();
        $this->assertEquals(0, $this->emptyGumballMachine->getBallCount());

        $this->emptyGumballMachine->releaseBall();
        $this->assertEquals(0, $this->emptyGumballMachine->getBallCount());
    }

    public function testMessagesEqualsWhenFullCircle(): void
    {
        $this->gumballMachine->insertQuarter();
        $this->gumballMachine->turnCrank();
        $this->gumballMachine->insertQuarter();

        $this->assertEquals(0, $this->emptyGumballMachine->getBallCount());

        $this->stdout->rewind();
        $this->assertEquals(NoQuarterState::INSERT_QUARTER_TEXT, $this->stdout->fgets());
        $this->assertEquals(HasQuarterState::TURN_CRANK_TEXT, $this->stdout->fgets());
        $this->assertEquals(PrivateGumballMachine::RELEASE_TEXT, $this->stdout->fgets());
        $this->assertEquals(NoQuarterState::INSERT_QUARTER_TEXT, $this->stdout->fgets());
    }

    protected function setUp(): void
    {
        $this->stdout = new SplTempFileObject();
        $this->gumballMachine = new PrivateGumballMachine($this->stdout, self::COUNT);
        $this->emptyGumballMachine = new PrivateGumballMachine($this->stdout, 0);
    }
}
