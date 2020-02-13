<?php
declare(strict_types=1);

namespace Lab05\Command\Menu;

use InvalidArgumentException;
use Lab05\Document\DocumentInterface;

class DeleteItemMenuCommand implements MenuCommandInterface
{
    /** @var DocumentInterface */
    private $document;

    public function __construct(DocumentInterface $document)
    {
        $this->document = $document;
    }

    public function execute(string $arguments): void
    {
        preg_match('/^(?<position>\d+)\s*$/', $arguments, $matches);
        $position = $matches['position'] ?? '';
        if (!is_numeric($position)) {
            throw new InvalidArgumentException('invalid command option: position' . PHP_EOL);
        }
        $this->document->deleteItem((int)$position);
    }
}