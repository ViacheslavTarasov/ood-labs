<?php
declare(strict_types=1);

use Lab05\App\Menu\ListMenuCommand;
use Lab05\Document\DocumentInterface;
use Lab05\Document\DocumentPrinter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ListMenuCommandTest extends TestCase
{
    /** @var ListMenuCommand */
    private $command;
    /** @var DocumentPrinter|MockObject */
    private $mockPrinter;
    /** @var DocumentInterface|MockObject */
    private $mockDocument;

    public function testExecuteCallsDoPrintMethod(): void
    {
        $this->mockPrinter->expects($this->once())->method('doPrint')->with($this->mockDocument);
        $this->command->execute('');
    }

    protected function setUp(): void
    {
        $this->mockDocument = $this->createMock(DocumentInterface::class);
        $this->mockPrinter = $this->createMock(DocumentPrinter::class);
        $this->command = new ListMenuCommand($this->mockDocument, $this->mockPrinter);
    }
}
