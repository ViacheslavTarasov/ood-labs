<?php
declare(strict_types=1);

use Lab05\Document\Command\DeleteDocumentItemCommand;
use Lab05\Document\Command\InsertDocumentItemCommand;
use Lab05\Document\DocumentItem;
use Lab05\Document\DocumentItems;
use Lab05\Document\ImageManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteDocumentItemCommandTest extends TestCase
{
    private const POSITION = 1;

    /** @var ImageManager */
    private $imageStorage;
    /** @var DocumentItems|MockObject */
    private $items;
    /** @var InsertDocumentItemCommand */
    private $command;

    public function testThrowsExceptionWhenCreateDeleteCommandWithEmptyItems(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new DeleteDocumentItemCommand($this->imageStorage, new DocumentItems(), 0);
    }

    public function testThrowsExceptionWhenCreateDeleteCommandIfItemNotFound(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new DeleteDocumentItemCommand($this->imageStorage, $this->items, $this->items->getItemCount() + 1);
    }

    public function testDeleteItemWasSuccessful(): void
    {
        $item = $this->items->getItem(self::POSITION);
        $countBefore = $this->items->getItemCount();
        $this->command->execute();
        $countAfter = $this->items->getItemCount();
        $this->assertEquals(1, $countBefore - $countAfter);
        $this->assertFalse($item === $this->items->getItem(self::POSITION));
    }

    public function testRestoreItemAfterUnexecuteWasSuccessful(): void
    {
        $item = $this->items->getItem(self::POSITION);
        $count = $this->items->getItemCount();
        $this->command->execute();
        $this->command->unexecute();
        $this->assertEquals($count, $this->items->getItemCount());
        $this->assertTrue($item === $this->items->getItem(self::POSITION));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->imageStorage = $this->createMock(ImageManager::class);
        $this->items = new DocumentItems();
        $this->items->add($this->createMock(DocumentItem::class));
        $this->items->add($this->createMock(DocumentItem::class));
        $this->items->add($this->createMock(DocumentItem::class));
        $this->command = new DeleteDocumentItemCommand($this->imageStorage, $this->items, self::POSITION);
    }
}
