<?php
declare(strict_types=1);

namespace Lab05\App\Menu;

use Lab05\Document\DocumentInterface;
use Lab05\Document\DocumentPrinter;
use Lab05\Menu\MenuCommandInterface;

class ListMenuCommand implements MenuCommandInterface
{
    /** @var DocumentPrinter */
    private $documentPrinter;
    /** @var DocumentInterface */
    private $document;

    public function __construct(DocumentInterface $document, DocumentPrinter $documentPrinter)
    {
        $this->document = $document;
        $this->documentPrinter = $documentPrinter;
    }

    public function execute(string $arguments): void
    {
        $this->documentPrinter->doPrint($this->document);
    }
}