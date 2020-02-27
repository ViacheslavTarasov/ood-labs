<?php

use Lab05\Document\Document;
use Lab05\Document\DocumentInterface;
use Lab05\Document\DocumentPrinter;
use Lab05\Document\DocumentSavingService;
use Lab05\Document\ImageManager;
use Lab05\History\History;
use PHPUnit\Framework\TestCase;

class DocumentPrinterTest extends TestCase
{
    /** @var SplTempFileObject */
    private $stdout;
    /** @var DocumentInterface */
    private $document;
    /** @var DocumentPrinter */
    private $documentPrinter;

    public function testDoPrintIfEmptyDocument(): void
    {
        $this->documentPrinter->doPrint($this->document);
        $this->stdout->rewind();
        $this->assertEquals('Title: ' . Document::DEFAULT_TITLE . PHP_EOL, $this->stdout->fgets());
    }

    public function testDoPrintIfDocumentWithTitleAndParagraph(): void
    {
        $this->document->insertParagraph('text', 0);
        $this->documentPrinter->doPrint($this->document);
        $this->stdout->rewind();
        $this->assertEquals('Title: ' . Document::DEFAULT_TITLE . PHP_EOL, $this->stdout->fgets());
        $this->assertEquals('0. Paragraph: text' . PHP_EOL, $this->stdout->fgets());
    }

    protected function setUp(): void
    {
        $this->stdout = new SplTempFileObject();
        $this->documentPrinter = new DocumentPrinter($this->stdout);
        $this->document = new Document(new History(10), $this->createMock(ImageManager::class), $this->createMock(DocumentSavingService::class));
    }
}
