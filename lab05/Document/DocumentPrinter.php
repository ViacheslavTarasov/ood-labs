<?php
declare(strict_types=1);

namespace Lab05\Document;

use SplFileObject;

class DocumentPrinter
{
    /** @var DocumentInterface */
    private $document;
    /** @var SplFileObject */
    private $stdout;

    public function __construct(DocumentInterface $document, SplFileObject $stdout)
    {
        $this->document = $document;
        $this->stdout = $stdout;
    }

    public function doPrint(): void
    {
        $this->printTitle($this->document->getTitle());
        $count = $this->document->getItemsCount();
        for ($i = 0; $i < $count; $i++) {
            $item = $this->document->getItem($i);
            if (null !== $item->getParagraph()) {
                $this->printParagraph($i, $item->getParagraph());
            }
            if (null !== $item->getImage()) {
                $this->printImage($i, $item->getImage());
            }
        }
    }

    private function printTitle(string $title): void
    {
        $this->stdout->fwrite("Title: $title" . PHP_EOL);
    }

    private function printParagraph(int $position, ParagraphInterface $paragraph): void
    {
        $this->stdout->fwrite("$position. Paragraph: {$paragraph->getText()}" . PHP_EOL);
    }

    private function printImage(int $position, ImageInterface $image): void
    {
        $this->stdout->fwrite("$position. Image: {$image->getWidth()} {$image->getHeight()} {$image->getPath()}" . PHP_EOL);
    }
}