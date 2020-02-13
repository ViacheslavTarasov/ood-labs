<?php
declare(strict_types=1);

namespace Lab05\Command\Menu;

use InvalidArgumentException;
use Lab05\Document\DocumentInterface;

class ReplaceTextMenuCommand implements MenuCommandInterface
{
    /** @var DocumentInterface */
    private $document;

    public function __construct(DocumentInterface $document)
    {
        $this->document = $document;
    }

    public function execute(string $arguments): void
    {
        preg_match('/^(?<position>\d+)\s+(?<text>.*\S+)\s*$/', $arguments, $matches);
        $position = $matches['position'] ?? '';
        $text = $matches['text'] ?? '';
        if (!is_numeric($position)) {
            throw new InvalidArgumentException('invalid command option: position' . PHP_EOL);
        }
        if (empty($text)) {
            throw new InvalidArgumentException('invalid command option: text' . PHP_EOL);
        }

        $this->document->replaceText($text, (int)$position);
    }
}