<?php
declare(strict_types=1);

use Lab05\Document\Document;
use Lab05\Document\DocumentInterface;
use Lab05\Document\DocumentSavingService;
use Lab05\Document\History;
use Lab05\Document\HistoryInterface;
use Lab05\Document\ImageManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    private const TITLE = 'title';
    private const TEXT = 'test text';
    private const SRC_PATH = '../test.png';
    private const WIDTH = 600;
    private const HEIGHT = 400;

    /** @var DocumentInterface */
    private $document;
    /** @var HistoryInterface */
    private $history;
    /** @var ImageManager|MockObject */
    private $imageManager;
    /** @var DocumentSavingService|MockObject */
    private $savingService;

    public function testSuccessfulSetTitle(): void
    {
        $this->assertEquals('', $this->document->getTitle());
        $this->document->setTitle(self::TITLE);
        $this->assertEquals(self::TITLE, $this->document->getTitle());
    }

    public function testCanUndoReturnFalseInitially(): void
    {
        $this->assertFalse($this->document->canUndo());
    }

    public function testCanRedoReturnFalseInitially(): void
    {
        $this->assertFalse($this->document->canRedo());
    }

    public function testTitleRestoredAfterUndoAndRedo(): void
    {
        $newTitle = 'new' . self::TITLE;
        $this->document->setTitle(self::TITLE);

        $this->document->setTitle($newTitle);
        $this->assertEquals($newTitle, $this->document->getTitle());

        $this->document->undo();
        $this->assertEquals(self::TITLE, $this->document->getTitle());

        $this->document->redo();
        $this->assertEquals($newTitle, $this->document->getTitle());
    }

    public function testReturnsZeroGetItemsCount(): void
    {
        $this->assertEquals(0, $this->document->getItemsCount());
    }

    public function testInsertedParagraphAndChangedItemsCount(): void
    {
        $this->document->insertParagraph(self::TEXT);
        $this->assertEquals(1, $this->document->getItemsCount());
        $this->document->insertParagraph(self::TEXT);
        $this->assertEquals(2, $this->document->getItemsCount());
    }

    public function testGetItemReturnInsertedParagraph(): void
    {
        $paragraph = $this->document->insertParagraph(self::TEXT);
        $this->assertEquals($paragraph, $this->document->getItem(0)->getParagraph());
    }

    public function testTextWasReplaced(): void
    {
        $newText = 'new' . self::TEXT;
        $paragraph = $this->document->insertParagraph(self::TEXT);

        $this->assertEquals(self::TEXT, $paragraph->getText());
        $this->document->replaceText($newText, 0);
        $this->assertEquals($newText, $paragraph->getText());
    }

    public function testDeleteItemAndUndoAndRedo(): void
    {
        $paragraph = $this->document->insertParagraph(self::TEXT);
        $this->document->undo();
        $this->assertEquals(0, $this->document->getItemsCount());
        $this->assertEquals(null, $this->document->getItem(0));

        $this->document->redo();
        $this->assertEquals(1, $this->document->getItemsCount());
        $this->assertEquals($paragraph, $this->document->getItem(0)->getParagraph());
    }

    public function testInsertImage(): void
    {
        $newPath = 'newpath';
        $this->imageManager->method('save')->willReturn($newPath);
        $image = $this->document->insertImage(self::SRC_PATH, self::WIDTH, self::HEIGHT);
        $this->assertEquals($newPath, $image->getPath());
        $this->assertEquals(self::WIDTH, $image->getWidth());
        $this->assertEquals(self::HEIGHT, $image->getHeight());

        $this->assertEquals(1, $this->document->getItemsCount());
    }

    public function testResizeImage(): void
    {
        $width = 10;
        $height = 20;
        $image = $this->document->insertImage(self::SRC_PATH, self::WIDTH, self::HEIGHT);

        $this->document->resizeImage(0, $width, $height);
        $this->assertEquals($width, $image->getWidth());
        $this->assertEquals($height, $image->getHeight());
    }

    public function testSave(): void
    {
        $path = '/1.html';
        $this->savingService->expects($this->once())->method('saveAsHtml')->with($path);
        $this->document->save($path);
    }

    protected function setUp(): void
    {
        $this->history = new History(10);
        $this->imageManager = $this->createMock(ImageManager::class);
        $this->savingService = $this->createMock(DocumentSavingService::class);
        $this->document = new Document($this->history, $this->imageManager, $this->savingService);
    }
}
