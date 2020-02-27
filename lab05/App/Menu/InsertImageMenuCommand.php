<?php
declare(strict_types=1);

namespace Lab05\App\Menu;

use InvalidArgumentException;
use Lab05\Document\DocumentInterface;
use Lab05\Menu\MenuCommandInterface;

class InsertImageMenuCommand implements MenuCommandInterface
{
    /** @var DocumentInterface */
    private $document;

    public function __construct(DocumentInterface $document)
    {
        $this->document = $document;
    }

    public function execute(string $arguments): void
    {
        preg_match('/^(?<position>\S+)\s+(?<width>\d+)\s+(?<height>\d+)\s+(?<filepath>\S+)\s*$/', $arguments, $matches);
        $position = $matches['position'] ?? '';
        $width = $matches['width'] ?? 0;
        $height = $matches['height'] ?? 0;
        $path = $matches['filepath'] ?? '';
        if (!is_numeric($position) && $position !== 'end') {
            throw new InvalidArgumentException('invalid command option: position' . PHP_EOL);
        }
        if (empty($width)) {
            throw new InvalidArgumentException('invalid command option: width' . PHP_EOL);
        }
        if (empty($height)) {
            throw new InvalidArgumentException('invalid command option: height' . PHP_EOL);
        }
        if (empty($path)) {
            throw new InvalidArgumentException('invalid command option: path' . PHP_EOL);
        }

        $position = $position === 'end' ? null : (int)$position;
        $this->document->insertImage($path, (int)$width, (int)$height, $position);
    }
}