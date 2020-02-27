<?php
declare(strict_types=1);

use Lab05\App\Menu\SaveMenuCommand;
use Lab05\Document\DocumentInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SaveMenuCommandTest extends TestCase
{
    private const PATH = 'test.html';

    /** @var SaveMenuCommand */
    private $command;
    /** @var DocumentInterface|MockObject */
    private $mockDocument;

    public function testThrowsExceptionIfEmptyArgs(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->command->execute('');
    }

    public function testCallDocumentSaveWithCorrectlyArgs(): void
    {
        $this->mockDocument->expects($this->once())->method('save')->with($this->equalTo(self::PATH));
        $this->command->execute(self::PATH);
    }

    protected function setUp(): void
    {
        $this->mockDocument = $this->createMock(DocumentInterface::class);
        $this->command = new SaveMenuCommand($this->mockDocument);
    }
}

