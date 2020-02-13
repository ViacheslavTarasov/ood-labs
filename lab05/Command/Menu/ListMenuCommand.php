<?php
declare(strict_types=1);

namespace Lab05\Command\Menu;

use Lab05\Document\DocumentPrinter;

class ListMenuCommand implements MenuCommandInterface
{
    /** @var DocumentPrinter */
    private $documentPrinter;

    /**
     * ListMenuCommand constructor.
     * @param DocumentPrinter $documentPrinter
     */
    public function __construct(DocumentPrinter $documentPrinter)
    {
        $this->documentPrinter = $documentPrinter;
    }

    public function execute(string $arguments): void
    {
        $this->documentPrinter->doPrint();
    }
}