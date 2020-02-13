<?php
declare(strict_types=1);

use Lab05\Command\Menu\UndoMenuCommand;
use Lab05\Document\DocumentInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UndoMenuCommandTest extends TestCase
{
    /** @var UndoMenuCommand */
    private $command;
    /** @var DocumentInterface|MockObject */
    private $mockDocument;

    public function testCalledUndoWhenExecute(): void
    {
        $this->mockDocument->expects($this->once())->method('undo');
        $this->command->execute('');
    }

    protected function setUp(): void
    {
        $this->mockDocument = $this->createMock(DocumentInterface::class);
        $this->command = new UndoMenuCommand($this->mockDocument);
    }
}
