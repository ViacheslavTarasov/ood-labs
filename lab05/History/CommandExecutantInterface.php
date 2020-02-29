<?php
declare(strict_types=1);

namespace Lab05\History;

interface CommandExecutantInterface
{
    public function addAndExecuteCommand(CommandInterface $command): void;
}