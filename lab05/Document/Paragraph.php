<?php
declare(strict_types=1);

namespace Lab05\Document;

use Lab05\Document\Command\ChangeTextCommand;
use Lab05\History\History;

class Paragraph implements ParagraphInterface
{
    /** @var History */
    private $history;
    /** @var string */
    private $text;

    public function __construct(History $history, string $text)
    {
        $this->history = $history;
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->history->addAndExecuteCommand(new ChangeTextCommand($this->text, $text));
    }
}