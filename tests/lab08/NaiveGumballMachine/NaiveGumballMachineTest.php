<?php
declare(strict_types=1);

use Lab08\NaiveGumballMachine\NaiveGumballMachine;
use PHPUnit\Framework\TestCase;

class NaiveGumballMachineTest extends TestCase
{
    private const COUNT = 3;
    private const REFILL_COUNT = 3;

    /** @var NaiveGumballMachine */
    private $gumballMachine;
    /** @var SplTempFileObject */
    private $stdout;

    public function testInsertedQuarterWhenNoQuarter(): void
    {
        $this->gumballMachine->insertQuarter();
        $this->assertEqualsFirstLine('You inserted a quarter');
    }

    public function testInsertedQuarterNotMoreThenMaxQuarterCountWhenInitiallyNoQuarter(): void
    {
        for ($i = 0; $i < NaiveGumballMachine::MAX_QUARTERS; $i++) {
            $this->gumballMachine->insertQuarter();
            $this->assertEqualsFirstLine('You inserted a quarter');
            $this->clearStdout();
        }
        $this->gumballMachine->insertQuarter();
        $this->assertEqualsFirstLine('You can\'t insert a quarter, max quarters count reached');
    }

    public function testNotInsertedWhenSoldOut(): void
    {
        $gumballMachine = $this->createGumballMachine(0);
        $gumballMachine->insertQuarter();
        $this->assertEqualsFirstLine('You can\'t insert a quarter, the machine is sold out');
    }

    public function testNotEjectedWhenNoQuarter(): void
    {
        $this->gumballMachine->ejectQuarter();
        $this->assertEqualsFirstLine('You haven\'t inserted a quarter');
    }

    public function testEjectedWhenQuarterWasMoreThanGumballsAndSoldOutNow(): void
    {
        $gumballMachine = $this->createGumballMachine(1);
        $gumballMachine->insertQuarter();
        $gumballMachine->insertQuarter();
        $gumballMachine->turnCrank();
        $this->clearStdout();

        $gumballMachine->ejectQuarter();
        $this->assertEqualsFirstLine('Quarters returned: ' . 1);
    }

    public function testEjectedQuarterWhenOneQuarterInserted(): void
    {
        $gumballMachine = $this->createGumballMachine(1);
        $gumballMachine->insertQuarter();
        $this->clearStdout();

        $gumballMachine->ejectQuarter();
        $this->assertEqualsFirstLine('Quarters returned: ' . 1);
    }

    public function testEjectedAllQuarterWhenMaxQuartersInserted(): void
    {
        for ($i = 0; $i < NaiveGumballMachine::MAX_QUARTERS; $i++) {
            $this->gumballMachine->insertQuarter();
            $this->clearStdout();
        }
        $this->gumballMachine->ejectQuarter();
        $this->assertEqualsFirstLine('Quarters returned: ' . NaiveGumballMachine::MAX_QUARTERS);
    }

    public function testTurnCrankDoesNotDispenseWhenSoldOut(): void
    {
        $gumballMachine = $this->createGumballMachine(0);
        $gumballMachine->turnCrank();
        $this->assertEqualsFirstLine('You turned but there\'s no gumballs');
    }


    public function testTurnCrankDoesNotDispenseWhenNoQuarter(): void
    {
        $this->gumballMachine->turnCrank();
        $this->assertEqualsFirstLine('You turned but there\'s no quarter');
    }

    public function testTurnCrankDispensesWhenAQuarterInserted(): void
    {
        $this->gumballMachine->insertQuarter();
        $this->clearStdout();

        $this->gumballMachine->turnCrank();
        $this->assertEqualsTurnCrankOutput();
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
        $this->assertEqualsFirstLine('You inserted a quarter');
    }

    public function testRefilledWhenNoQuarter(): void
    {
        $this->gumballMachine->refill(self::REFILL_COUNT);
        $this->assertEqualsFirstLine('Refill gumballs: ' . self::REFILL_COUNT);
    }

    public function testRefilledWhenSoldOut(): void
    {
        $gumballMachine = $this->createGumballMachine(0);
        $gumballMachine->refill(self::REFILL_COUNT);
        $this->assertEqualsFirstLine('Refill gumballs: ' . self::REFILL_COUNT);
    }

    public function testRefilledWhenHasQuarter(): void
    {
        $this->gumballMachine->insertQuarter();
        $this->clearStdout();

        $this->gumballMachine->refill(self::REFILL_COUNT);
        $this->assertEqualsFirstLine('Refill gumballs: ' . self::REFILL_COUNT);
    }

    public function testEjectedQuarterAfterRefillWhenHasQuarter(): void
    {
        $this->gumballMachine->insertQuarter();
        $this->gumballMachine->insertQuarter();
        $this->gumballMachine->refill(self::REFILL_COUNT);
        $this->clearStdout();

        $this->gumballMachine->ejectQuarter();
        $this->assertEqualsFirstLine('Quarters returned: ' . 2);
    }

    protected function setUp(): void
    {
        $this->stdout = new SplTempFileObject();
        $this->gumballMachine = $this->createGumballMachine(self::COUNT);
    }

    private function createGumballMachine(int $count): NaiveGumballMachine
    {
        return new NaiveGumballMachine($this->stdout, $count);
    }

    private function getFirstLineFromStdout(): string
    {
        $this->stdout->rewind();
        return $this->stdout->fgets();
    }

    private function assertEqualsFirstLine(string $line): void
    {
        $this->stdout->rewind();
        $this->assertEquals($line . PHP_EOL, $this->getFirstLineFromStdout());
    }

    private function clearStdout(): void
    {
        $this->stdout->ftruncate(0);
    }

    private function assertEqualsTurnCrankOutput(): void
    {
        $this->stdout->rewind();
        $this->assertEquals('You turned...' . PHP_EOL, $this->stdout->fgets());
        $this->assertEquals('A gumball comes rolling out the slot' . PHP_EOL, $this->stdout->fgets());
    }
}
