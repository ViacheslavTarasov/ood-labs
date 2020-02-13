<?php
declare(strict_types=1);

use Lab05\Command\Document\DeleteDocumentItemCommand;
use Lab05\Command\Document\InsertDocumentItemCommand;
use Lab05\Document\DocumentItemInterface;
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
        new DeleteDocumentItemCommand($this->imageStorage, $this->items, $this->items->getCountItems() + 1);
    }

    public function testDeleteItemWasSuccessful(): void
    {
        $item = $this->items->getItem(self::POSITION);
        $countBefore = $this->items->getCountItems();
        $this->command->execute();
        $countAfter = $this->items->getCountItems();
        $this->assertEquals(1, $countBefore - $countAfter);
        $this->assertFalse($item === $this->items->getItem(self::POSITION));
    }

    public function testRestoreItemAfterUnexecuteWasSuccessful(): void
    {
        $item = $this->items->getItem(self::POSITION);
        $count = $this->items->getCountItems();
        $this->command->execute();
        $this->command->unexecute();
        $this->assertEquals($count, $this->items->getCountItems());
        $this->assertTrue($item === $this->items->getItem(self::POSITION));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->imageStorage = $this->createMock(ImageManager::class);
        $this->items = new DocumentItems();
        $this->items->add($this->createMock(DocumentItemInterface::class));
        $this->items->add($this->createMock(DocumentItemInterface::class));
        $this->items->add($this->createMock(DocumentItemInterface::class));
        $this->command = new DeleteDocumentItemCommand($this->imageStorage, $this->items, self::POSITION);
    }
}
