<?php
declare(strict_types=1);

use Lab08\MultiGumballMachine\Context\PrivateGumballMachine;
use Lab08\MultiGumballMachine\State\HasQuarterState;
use Lab08\MultiGumballMachine\State\NoQuarterState;
use PHPUnit\Framework\TestCase;

class PrivateGumballMachineTest extends TestCase
{
    private const COUNT = 3;

    /** @var PrivateGumballMachine */
    private $gumballMachine;
    /** @var SplTempFileObject */
    private $stdout;

    public function testCreteMachineWithNegativeBallsCountThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new PrivateGumballMachine($this->stdout, -1);
    }

    public function testGetCountBallsEqualsInitiallyCount(): void
    {
        $this->assertEquals(self::COUNT, $this->gumballMachine->getBallCount());
    }

    public function testReleaseBallDecreasesBallsCountAndWriteInStdout(): void
    {
        $this->gumballMachine->releaseBall();
        $this->assertEquals(self::COUNT - 1, $this->gumballMachine->getBallCount());

        $this->gumballMachine->releaseBall();
        $this->assertEquals(self::COUNT - 2, $this->gumballMachine->getBallCount());

        $this->stdout->rewind();
        $this->assertEquals(PrivateGumballMachine::RELEASE_TEXT, $this->stdout->fgets());
        $this->assertEquals(PrivateGumballMachine::RELEASE_TEXT, $this->stdout->fgets());
    }

    public function testReleaseBallDoesNotDecreaseCountGumballsWhenNoGumballs(): void
    {
        $emptyGumballMachine = $this->createGumballMachine(0);
        $emptyGumballMachine->releaseBall();
        $this->assertEquals(0, $emptyGumballMachine->getBallCount());

        $emptyGumballMachine->releaseBall();
        $this->assertEquals(0, $emptyGumballMachine->getBallCount());
    }

    public function testGetQuarterCountReturnsZeroInitially(): void
    {
        $this->assertEquals(0, $this->gumballMachine->getQuarterCount());
    }

    public function testAddQuarterIncreaseQuartersCount(): void
    {
        $this->gumballMachine->addQuarter();
        $this->assertEquals(1, $this->gumballMachine->getQuarterCount());
        $this->gumballMachine->addQuarter();
        $this->assertEquals(2, $this->gumballMachine->getQuarterCount());
    }

    public function testAddQuarterThrowsExceptionWhenMaxQuartersCountReached(): void
    {
        for ($i = 0; $i < PrivateGumballMachine::MAX_QUARTERS; $i++) {
            $this->gumballMachine->addQuarter();
        }
        $this->expectException(RuntimeException::class);
        $this->gumballMachine->addQuarter();
    }

    public function testEjectedWhenQuarterWasMoreThanGumballsAndSoldOutNow(): void
    {
        $gumballMachine = $this->createGumballMachine(1);
        $gumballMachine->insertQuarter();
        $gumballMachine->insertQuarter();
        $gumballMachine->insertQuarter();
        $gumballMachine->turnCrank();
        $this->clearStdout();

        $gumballMachine->ejectQuarter();
        $this->assertEquals(PrivateGumballMachine::RETURN_QUARTERS_TEXT . 2 . PHP_EOL, $this->getFirstLineFromStdout());
    }

    public function testEveryTurnCrankDispensesByOneGumballWhenSeveralQuarterInserted(): void
    {
        $this->gumballMachine->insertQuarter();
        $this->gumballMachine->insertQuarter();
        $this->clearStdout();

        $this->gumballMachine->turnCrank();
        $this->assertEqualsTurnCrankOutput();

        $this->clearStdout();

        $this->gumballMachine->turnCrank();
        $this->assertEqualsTurnCrankOutput();
    }


    public function testCanInsertQuartersWhenNotAllGumballsDispensed(): void
    {
        $gumballMachine = $this->createGumballMachine(5);
        $gumballMachine->insertQuarter();
        $gumballMachine->insertQuarter();
        $gumballMachine->turnCrank();
        $this->clearStdout();

        $gumballMachine->insertQuarter();
        $this->assertEquals(PrivateGumballMachine::INSERT_QUARTER_TEXT, $this->getFirstLineFromStdout());
    }

    public function testRefillChangesGumballsCount(): void
    {
        $newGumballsCount = 123;
        $this->gumballMachine->refill($newGumballsCount);
        $this->assertEquals($newGumballsCount, $this->gumballMachine->getBallCount());
    }

    public function testRefillThrowsExceptionWhenNewGumballsCountIsNegative(): void
    {
        $newGumballsCount = -1;
        $this->expectException(InvalidArgumentException::class);
        $this->gumballMachine->refill($newGumballsCount);
    }

    public function testWorksSuccessFullyFullCycle(): void
    {
        $this->gumballMachine->insertQuarter();
        $this->gumballMachine->turnCrank();
        $this->gumballMachine->insertQuarter();

        $this->stdout->rewind();
        $this->assertEquals(NoQuarterState::INSERT_QUARTER_TEXT, $this->stdout->fgets());
        $this->assertEquals(HasQuarterState::TURN_CRANK_TEXT, $this->stdout->fgets());
        $this->assertEquals(PrivateGumballMachine::RELEASE_TEXT, $this->stdout->fgets());
        $this->assertEquals(NoQuarterState::INSERT_QUARTER_TEXT, $this->stdout->fgets());
    }

    protected function setUp(): void
    {
        $this->stdout = new SplTempFileObject();
        $this->gumballMachine = $this->createGumballMachine(self::COUNT);
    }

    private function createGumballMachine(int $count): PrivateGumballMachine
    {
        return new PrivateGumballMachine($this->stdout, $count);
    }

    private function clearStdout(): void
    {
        $this->stdout->ftruncate(0);
    }

    private function getFirstLineFromStdout(): string
    {
        $this->stdout->rewind();
        return $this->stdout->fgets();
    }

    private function assertEqualsTurnCrankOutput(): void
    {
        $this->stdout->rewind();
        $this->assertEquals('You turned...' . PHP_EOL, $this->stdout->fgets());
        $this->assertEquals('A gumball comes rolling out the slot' . PHP_EOL, $this->stdout->fgets());
    }
}
