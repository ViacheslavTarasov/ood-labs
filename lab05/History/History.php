<?php
declare(strict_types=1);

namespace Lab05\History;

class History
{
    /** @var CommandInterface[] */
    private $commands = [];
    /** @var int */
    private $nextCommandIndex = 0;
    /** @var int */
    private $maxLength;

    public function __construct(int $maxLength)
    {
        if ($maxLength < 1) {
            throw new \InvalidArgumentException('too few $maxLength');
        }
        $this->maxLength = $maxLength;
    }

    public function undo(): void
    {
        if ($this->canUndo()) {
            $this->commands[$this->nextCommandIndex - 1]->unexecute();
            $this->nextCommandIndex--;
        }
    }

    public function canUndo(): bool
    {
        return $this->nextCommandIndex > 0;
    }

    public function redo(): void
    {
        if ($this->canRedo()) {
            $this->commands[$this->nextCommandIndex]->execute();
            $this->nextCommandIndex++;
        }
    }

    public function canRedo(): bool
    {
        return $this->nextCommandIndex < count($this->commands);
    }

    public function addAndExecuteCommand(CommandInterface $command): void
    {
        $command->execute();
        $count = count($this->commands);
        if ($this->nextCommandIndex < $count) {
            $this->commands = array_slice($this->commands, 0, $this->nextCommandIndex);
        } elseif ($count === $this->maxLength) {
            $this->commands = array_slice($this->commands, 1, $this->maxLength - 1);
            $this->nextCommandIndex--;
        }
        $this->nextCommandIndex++;
        $this->commands[] = $command;
    }
}