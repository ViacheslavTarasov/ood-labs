<?php
declare(strict_types=1);

use Lab05\Document\Command\InsertDocumentItemCommand;
use Lab05\Document\DocumentItem;
use Lab05\Document\DocumentItems;
use Lab05\Document\ImageManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class InsertDocumentItemCommandTest extends TestCase
{
    private const POSITION = 3;

    /** @var ImageManager */
    private $imageStorage;
    /** @var DocumentItem|MockObject */
    private $item;
    /** @var DocumentItems|MockObject */
    private $items;
    /** @var InsertDocumentItemCommand */
    private $command;

    public function testWasCalledAddMethodOnceWhenExecute(): void
    {
        $this->items->method('getItemCount')->willReturn(self::POSITION);
        $this->items->expects($this->once())->method('add')->with($this->item, self::POSITION);
        $this->command->execute();
        $this->command->execute();
    }

    public function testWasNotCalledDeleteItemIfNotCalledExecuteBeforeUnexecute(): void
    {
        $this->items->expects($this->exactly(0))->method('deleteItem');
        $this->command->unexecute();
    }

    public function testWasCalledDeleteItemOnceWhenUnexecute(): void
    {
        $this->items->method('getItemCount')->willReturn(self::POSITION);
        $this->command->execute();
        $this->items->expects($this->once())->method('deleteItem')->with(self::POSITION);
        $this->command->unexecute();
        $this->command->unexecute();
    }

    public function testExecuteAddsItemWhenNullPosition(): void
    {
        $this->items->method('getItemCount')->willReturn(self::POSITION);

        $command = $this->getCommand(null);

        $this->items->expects($this->once())->method('add')->with($this->item, self::POSITION);
        $command->execute();
    }

    public function testUnexecuteDeleteItemWhenNullPosition(): void
    {
        $this->items->method('getItemCount')->willReturn(self::POSITION);

        $command = $this->getCommand(null);

        $command->execute();
        $this->items->expects($this->once())->method('deleteItem')->with(self::POSITION);
        $command->unexecute();
    }

    public function testThrowsExceptionWhenNegativePosition(): void
    {
        $command = $this->getCommand(-1);
        $this->expectException(InvalidArgumentException::class);
        $command->execute();
    }

    public function testThrowsExceptionWhenInvalidPosition(): void
    {
        $command = $this->getCommand(self::POSITION + 1);
        $this->items->method('getItemCount')->willReturn(self::POSITION);
        $this->expectException(InvalidArgumentException::class);
        $command->execute();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->imageStorage = $this->createMock(ImageManager::class);
        $this->item = $this->createMock(DocumentItem::class);
        $this->items = $this->createMock(DocumentItems::class);
        $this->command = $this->getCommand(self::POSITION);
    }

    private function getCommand(int $position = null): InsertDocumentItemCommand
    {
        return new InsertDocumentItemCommand($this->imageStorage, $this->items, $this->item, $position);
    }
}
