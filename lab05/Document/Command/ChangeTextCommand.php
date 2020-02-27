<?php
declare(strict_types=1);

namespace Lab05\Document\Command;

class ChangeTextCommand extends AbstractCommand
{
    /** @var string */
    private $text;
    /** @var string */
    private $newText;

    public function __construct(string &$text, string $newText)
    {
        $this->text = &$text;
        $this->newText = $newText;
    }

    protected function doExecute(): void
    {
        $this->changeTextValues();
    }

    protected function doUnexecute(): void
    {
        $this->changeTextValues();
    }

    private function changeTextValues(): void
    {
        [$this->text, $this->newText] = [$this->newText, $this->text];
    }
}