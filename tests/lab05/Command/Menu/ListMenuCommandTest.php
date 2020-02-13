<?php
declare(strict_types=1);

use Lab05\Command\Menu\ListMenuCommand;
use Lab05\Document\DocumentPrinter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ListMenuCommandTest extends TestCase
{
    /** @var ListMenuCommand */
    private $command;
    /** @var DocumentPrinter|MockObject */
    private $mockPrinter;

    public function testCalledDoPrintWhenExecute(): void
    {
        $this->mockPrinter->expects($this->once())->method('doPrint');
        $this->command->execute('');
    }

    protected function setUp(): void
    {
        $this->mockPrinter = $this->createMock(DocumentPrinter::class);
        $this->command = new ListMenuCommand($this->mockPrinter);
    }
}
