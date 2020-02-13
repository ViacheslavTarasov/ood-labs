<?php
declare(strict_types=1);

use Lab05\Command\Document\ChangeTextCommand;
use Lab05\Document\History;
use Lab05\Document\HistoryInterface;
use Lab05\Document\Paragraph;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ParagraphTest extends TestCase
{
    private const TEXT = 'test text';
    /** @var Paragraph */
    private $paragraph;
    /** @var HistoryInterface|MockObject */
    private $history;

    public function testGettersReturn(): void
    {
        $this->assertEquals(self::TEXT, $this->paragraph->getText());
    }

    public function testCallsAddAndExecuteMethodWhenSetText(): void
    {
        $this->history->expects($this->once())->method('addAndExecuteCommand')->with($this->isInstanceOf(ChangeTextCommand::class));
        $this->paragraph->setText(self::TEXT);
    }

    public function testTextWasChanged(): void
    {
        $newText = 'new' . self::TEXT;
        $paragraph = new Paragraph(new History(10), self::TEXT);
        $paragraph->setText($newText);
        $this->assertEquals($newText, $paragraph->getText());
    }

    protected function setUp(): void
    {
        $this->history = $this->createMock(HistoryInterface::class);
        $this->paragraph = new Paragraph($this->history, self::TEXT);
    }
}