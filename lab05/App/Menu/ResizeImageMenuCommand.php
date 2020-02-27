<?php
declare(strict_types=1);

namespace Lab05\App\Menu;

use InvalidArgumentException;
use Lab05\Document\DocumentInterface;
use Lab05\Menu\MenuCommandInterface;

class ResizeImageMenuCommand implements MenuCommandInterface
{
    /** @var DocumentInterface */
    private $document;

    public function __construct(DocumentInterface $document)
    {
        $this->document = $document;
    }

    public function execute(string $arguments): void
    {
        preg_match('/^(?<position>\S+)\s+(?<width>\d+)\s+(?<height>\d+)\s*$/', $arguments, $matches);
        $position = $matches['position'] ?? '';
        $width = $matches['width'] ?? 0;
        $height = $matches['height'] ?? 0;
        if (!is_numeric($position) && $position !== 'end') {
            throw new InvalidArgumentException('invalid command option: position' . PHP_EOL);
        }

        if (empty($width)) {
            throw new InvalidArgumentException('invalid command option: width' . PHP_EOL);
        }
        if (empty($height)) {
            throw new InvalidArgumentException('invalid command option: height' . PHP_EOL);
        }
        $position = $position === 'end' ? null : (int)$position;
        $this->document->resizeImage($position, (int)$width, (int)$height);
    }
}