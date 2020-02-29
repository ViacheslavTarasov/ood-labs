<?php
declare(strict_types=1);

use Lab05\Document\Document;
use Lab05\Document\DocumentInterface;
use Lab05\Document\DocumentSavingService;
use Lab05\Document\ImageManager;
use Lab05\History\History;
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
    /** @var History */
    private $history;
    /** @var ImageManager|MockObject */
    private $mockImageManager;
    /** @var DocumentSavingService|MockObject */
    private $mockSavingService;

    public function testSuccessfulSetTitle(): void
    {
        $this->assertEquals('', $this->document->getTitle());
        $this->document->setTitle(self::TITLE);
        $this->assertEquals(self::TITLE, $this->document->getTitle());
    }

    public function testCanUndoReturnsFalseInitially(): void
    {
        $this->assertFalse($this->document->canUndo());
    }

    public function testCanRedoReturnsFalseInitially(): void
    {
        $this->assertFalse($this->document->canRedo());
    }

    public function testThrowsExceptionUndoIfCanUndoIsFalse(): void
    {
        $this->expectException(RuntimeException::class);
        $this->document->undo();
    }

    public function testThrowsExceptionRedoIfCanRedoIsFalse(): void
    {
        $this->expectException(RuntimeException::class);
        $this->document->redo();
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

    public function testGetItemsCountReturnsZero(): void
    {
        $this->assertEquals(0, $this->document->getItemsCount());
    }

    public function testInsertParagraphThrowsExceptionWhenPositionIsGreaterThanItemsCount(): void
    {
        $this->document->getItemsCount();
        $position = $this->document->getItemsCount() + 1;
        $this->expectException(InvalidArgumentException::class);
        $this->document->insertParagraph(self::TEXT, $position);
    }

    public function testInsertedParagraphAndChangedItemsCount(): void
    {
        $this->document->insertParagraph(self::TEXT);
        $this->assertEquals(1, $this->document->getItemsCount());
        $this->document->insertParagraph(self::TEXT);
        $this->assertEquals(2, $this->document->getItemsCount());
    }

    public function testGetItemReturnsInsertedParagraph(): void
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

    /**
     * @dataProvider invalidPositionProvider
     * @param int $position
     */
    public function testThrowsExceptionReplaceTextWhenInvalidPosition(int $position): void
    {
        $this->document->insertParagraph(self::TEXT);
        $this->expectException(InvalidArgumentException::class);
        $this->document->replaceText('new text', $position);
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

    /**
     * @dataProvider invalidPositionProvider
     * @param int $position
     */
    public function testThrowsExceptionDeleteItemWhenInvalidPosition(int $position): void
    {
        $this->document->insertParagraph(self::TEXT);
        $this->expectException(InvalidArgumentException::class);
        $this->document->deleteItem($position);
    }

    public function testImageInserted(): void
    {
        $newPath = 'newpath';
        $this->mockImageManager->method('save')->willReturn($newPath);
        $image = $this->document->insertImage(self::SRC_PATH, self::WIDTH, self::HEIGHT);
        $this->assertEquals($newPath, $image->getPath());
        $this->assertEquals(self::WIDTH, $image->getWidth());
        $this->assertEquals(self::HEIGHT, $image->getHeight());

        $this->assertEquals(1, $this->document->getItemsCount());
    }

    public function testInsertImageThrowsExceptionWhenPositionIsGreaterThanItemsCount(): void
    {
        $position = $this->document->getItemsCount() + 1;
        $this->expectException(InvalidArgumentException::class);
        $this->document->insertImage(self::SRC_PATH, self::WIDTH, self::HEIGHT, $position);
    }

    public function testResizeShouldChangeImageSize(): void
    {
        $width = 10;
        $height = 20;
        $image = $this->document->insertImage(self::SRC_PATH, self::WIDTH, self::HEIGHT);

        $this->document->resizeImage(0, $width, $height);
        $this->assertEquals($width, $image->getWidth());
        $this->assertEquals($height, $image->getHeight());
    }

    /**
     * @dataProvider invalidPositionProvider
     * @param int $position
     */
    public function testThrowsExceptionResizeImageWhenInvalidPosition(int $position): void
    {
        $this->document->insertImage(self::SRC_PATH, self::WIDTH, self::HEIGHT);
        $this->expectException(InvalidArgumentException::class);
        $this->document->resizeImage($position, self::WIDTH + 10, self::HEIGHT + 10);
    }

    public function testSaveCallsSavingServiceSaveAsHtml(): void
    {
        $path = '/1.html';
        $this->mockSavingService->expects($this->once())->method('saveAsHtml')->with($path);
        $this->document->save($path);
    }

    public function invalidPositionProvider(): array
    {
        return [
            [-1],
            [1],
            [100],
        ];
    }

    protected function setUp(): void
    {
        $this->history = new History(10);
        $this->mockImageManager = $this->createMock(ImageManager::class);
        $this->mockSavingService = $this->createMock(DocumentSavingService::class);
        $this->document = new Document($this->history, $this->mockImageManager, $this->mockSavingService);
    }
}
