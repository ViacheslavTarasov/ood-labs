<?php
declare(strict_types=1);

namespace Lab05\App\Menu;

use InvalidArgumentException;
use Lab05\Document\DocumentInterface;
use Lab05\Menu\MenuCommandInterface;

class SaveMenuCommand implements MenuCommandInterface
{
    /** @var DocumentInterface */
    private $document;

    public function __construct(DocumentInterface $document)
    {
        $this->document = $document;
    }

    public function execute(string $arguments): void
    {
        $path = trim($arguments);
        if (empty($path)) {
            throw new InvalidArgumentException('invalid command option: path' . PHP_EOL);
        }
        $this->document->save($path);
    }
}