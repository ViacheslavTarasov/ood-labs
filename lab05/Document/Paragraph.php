<?php
declare(strict_types=1);

namespace Lab05\Document;

use Lab05\Document\Command\ChangeTextCommand;
use Lab05\History\CommandExecutantInterface;

class Paragraph implements ParagraphInterface
{
    /** @var CommandExecutantInterface */
    private $commandExecutant;
    /** @var string */
    private $text;

    public function __construct(CommandExecutantInterface $commandExecutant, string $text)
    {
        $this->commandExecutant = $commandExecutant;
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->commandExecutant->addAndExecuteCommand(new ChangeTextCommand($this->text, $text));
    }
}