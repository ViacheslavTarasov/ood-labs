<?php
declare(strict_types=1);

use Lab05\Command\Document\CommandInterface;
use Lab05\Document\History;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class HistoryTest extends TestCase
{
    private const MAX_LENGTH = 3;
    private const COUNT_CALLS = 3;
    /** @var History */
    private $history;
    /** @var CommandInterface|MockObject */
    private $command;

    public function testThrowsExceptionWhenCreateHistoryWithZeroMaxLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new History(0);
    }

    public function testMethodExecuteWasCalledWhenAddAndExecuteCommand(): void
    {
        $this->command->expects($this->once())->method('execute');
        $this->history->addAndExecuteCommand($this->command);
    }

    public function testMethodUnexecuteWasCalledWhenUndoAsManyTimesAsAddedCommands(): void
    {
        for ($i = 0; $i < self::COUNT_CALLS; $i++) {
            $this->history->addAndExecuteCommand($this->command);
        }

        $this->command->expects($this->exactly(self::COUNT_CALLS))->method('unexecute');
        for ($i = 0; $i < self::COUNT_CALLS + 1; $i++) {
            $this->history->undo();
        }
    }

    public function testMethodExecuteNotCalledAfterRedoIfNoCommandsForRedo(): void
    {
        $this->history->addAndExecuteCommand($this->command);
        $this->command->expects($this->exactly(0))->method('execute');
        $this->history->redo();
    }

    public function testUndoCommandsInReverseOrder(): void
    {
        $command1 = $this->createMock(CommandInterface::class);
        $command2 = $this->createMock(CommandInterface::class);
        $this->history->addAndExecuteCommand($command1);
        $this->history->addAndExecuteCommand($command2);

        $command1->expects($this->exactly(0))->method('unexecute');
        $command2->expects($this->once())->method('unexecute');

        $this->history->undo();
    }

    public function testCommandStampedOutIfAddedMoreThenMaxLength(): void
    {
        $command = $this->createMock(CommandInterface::class);
        $command->expects($this->once())->method('execute');
        $command->expects($this->exactly(0))->method('unexecute');

        $this->history->addAndExecuteCommand($command);

        $commands = [];
        for ($i = 0; $i < self::MAX_LENGTH; $i++) {
            $commands[$i] = $this->createMock(CommandInterface::class);
            $commands[$i]->expects($this->once())->method('execute');
            $commands[$i]->expects($this->once())->method('unexecute');
            $this->history->addAndExecuteCommand($commands[$i]);
        }

        for ($i = 0; $i < self::MAX_LENGTH + 1; $i++) {
            $this->history->undo();
        }
    }

    public function testLostCanceledCommandAfterAddNewCommand(): void
    {
        /** @var  CommandInterface[] $commands */
        $commands = [];
        for ($i = 0; $i < self::MAX_LENGTH; $i++) {
            $commands[$i] = $this->createMock(CommandInterface::class);
            $this->history->addAndExecuteCommand($commands[$i]);
        }

        $commands[self::MAX_LENGTH - 1]->expects($this->once())->method('unexecute');
        $commands[self::MAX_LENGTH - 1]->expects($this->exactly(0))->method('execute');

        $this->history->undo();

        $newCommand = $this->createMock(CommandInterface::class);
        $this->history->addAndExecuteCommand($newCommand);
        $newCommand->expects($this->once())->method('unexecute');
        $newCommand->expects($this->once())->method('execute');

        $this->history->undo();
        $this->history->redo();

        $this->history->redo();
    }

    public function testMethodExecuteWasCalledWhenRedoAsManyTimesAsUndoCommands(): void
    {
        for ($i = 0; $i < self::COUNT_CALLS; $i++) {
            $this->history->addAndExecuteCommand($this->command);
        }

        for ($i = 0; $i < self::COUNT_CALLS; $i++) {
            $this->history->undo();
        }
        $this->command->expects($this->exactly(self::COUNT_CALLS))->method('execute');
        for ($i = 0; $i < self::COUNT_CALLS + 1; $i++) {
            $this->history->redo();
        }
    }

    public function testCanUndoIsFalseIfEmptyHistory(): void
    {
        $this->assertFalse($this->history->canUndo());
    }

    public function testCanUndoIsTrueIfCommandExecuted(): void
    {
        $this->history->addAndExecuteCommand($this->command);
        $this->assertTrue($this->history->canUndo());
    }

    public function testCanUndoIsFalseIfCommandExecutedAndCalledUndo(): void
    {
        $this->history->addAndExecuteCommand($this->command);
        $this->history->undo();
        $this->assertFalse($this->history->canUndo());
    }

    public function testCanRedoIsFalseIfEmptyHistory(): void
    {
        $this->assertFalse($this->history->canRedo());
    }

    public function testCanRedoIsFalseIfAddedCommandButNotCalledUndo(): void
    {
        $this->history->addAndExecuteCommand($this->command);
        $this->assertFalse($this->history->canRedo());
    }

    public function testCanRedoIsTrueAfterUndo(): void
    {
        $this->history->addAndExecuteCommand($this->command);
        $this->history->undo();
        $this->assertTrue($this->history->canRedo());
    }

    public function testCanRedoIsFalseAfterRedo(): void
    {
        $this->history->addAndExecuteCommand($this->command);
        $this->history->undo();
        $this->history->redo();
        $this->assertFalse($this->history->canRedo());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->history = new History(self::MAX_LENGTH);
        $this->command = $this->createMock(CommandInterface::class);
    }
}
