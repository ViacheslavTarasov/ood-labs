<?php
declare(strict_types=1);

namespace Lab05\Document;

use Lab05\Command\Document\CommandInterface;

interface HistoryInterface
{
    public function canUndo(): bool;

    public function undo(): void;

    public function canRedo(): bool;

    public function redo(): void;

    public function addAndExecuteCommand(CommandInterface $command): void;
}