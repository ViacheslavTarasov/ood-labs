<?php
declare(strict_types=1);

namespace Lab05\App\Menu;

use Lab05\Document\DocumentInterface;
use Lab05\Menu\MenuCommandInterface;

class RedoMenuCommand implements MenuCommandInterface
{
    /** @var DocumentInterface */
    private $document;

    public function __construct(DocumentInterface $document)
    {
        $this->document = $document;
    }

    public function execute(string $arguments): void
    {
        $this->document->redo();
    }
}