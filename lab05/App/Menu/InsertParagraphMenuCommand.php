<?php
declare(strict_types=1);

namespace Lab05\App\Menu;

use InvalidArgumentException;
use Lab05\Document\DocumentInterface;
use Lab05\Menu\MenuCommandInterface;

class InsertParagraphMenuCommand implements MenuCommandInterface
{
    /** @var DocumentInterface */
    private $document;

    public function __construct(DocumentInterface $document)
    {
        $this->document = $document;
    }

    public function execute(string $arguments): void
    {
        preg_match('/^(?<position>\S+)\s+(?<text>.*\S+)\s*$/', $arguments, $matches);
        $position = $matches['position'] ?? '';
        $text = $matches['text'] ?? '';
        if (!is_numeric($position) && $position !== 'end') {
            throw new InvalidArgumentException('invalid command option: position' . PHP_EOL);
        }

        if (empty($text)) {
            throw new InvalidArgumentException('invalid command option: text' . PHP_EOL);
        }

        $position = $position === 'end' ? null : (int)$position;
        $this->document->insertParagraph($text, $position);
    }
}