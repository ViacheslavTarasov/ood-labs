<?php
declare(strict_types=1);

namespace Lab05\Command\Menu;

use Lab05\Document\DocumentInterface;

class UndoMenuCommand implements MenuCommandInterface
{
    /** @var DocumentInterface */
    private $document;

    public function __construct(DocumentInterface $document)
    {
        $this->document = $document;
    }

    public function execute(string $arguments): void
    {
        $this->document->undo();
    }
}