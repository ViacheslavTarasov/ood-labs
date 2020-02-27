<?php
declare(strict_types=1);

use Lab05\App\Menu\RedoMenuCommand;
use Lab05\Document\DocumentInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RedoMenuCommandTest extends TestCase
{
    /** @var RedoMenuCommand */
    private $command;
    /** @var DocumentInterface|MockObject */
    private $mockDocument;

    public function testCalledRedoWhenExecute(): void
    {
        $this->mockDocument->expects($this->once())->method('redo');
        $this->command->execute('');
    }

    protected function setUp(): void
    {
        $this->mockDocument = $this->createMock(DocumentInterface::class);
        $this->command = new RedoMenuCommand($this->mockDocument);
    }
}
