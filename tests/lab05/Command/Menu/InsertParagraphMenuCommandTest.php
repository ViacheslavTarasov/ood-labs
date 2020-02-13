<?php
declare(strict_types=1);

use Lab05\Command\Menu\InsertParagraphMenuCommand;
use Lab05\Document\DocumentInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class InsertParagraphMenuCommandTest extends TestCase
{
    private const POSITION = 0;
    private const POSITION_END = 'end';
    private const TEXT = 'test text';
    /** @var InsertParagraphMenuCommand */
    private $command;
    /** @var DocumentInterface|MockObject */
    private $mockDocument;

    public function testThrowsExceptionIfEmptyArgs(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->command->execute('');
    }

    public function testCallDocumentInsertParagraphWithCorrectlyArgs(): void
    {
        $this->mockDocument->expects($this->once())->method('insertParagraph')
            ->with(
                $this->equalTo(self::TEXT),
                $this->equalTo(self::POSITION)
            );
        $this->command->execute(self::POSITION . ' ' . self::TEXT);
    }

    public function testCallDocumentInsertParagraphWithCorrectlyArgsIfEndPosition(): void
    {
        $this->mockDocument->expects($this->once())->method('insertParagraph')
            ->with(
                $this->equalTo(self::TEXT),
                $this->equalTo(NULL)
            );
        $this->command->execute(self::POSITION_END . ' ' . self::TEXT);
    }

    /**
     * @dataProvider dataProvider
     * @param string $args
     */
    public function testThrowsExceptionWhenInvalidArgs(string $args): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->command->execute($args);
    }

    public function dataProvider(): array
    {
        return [
            [self::POSITION . ' ' . ''],
            ['start' . ' ' . self::TEXT],
        ];
    }

    protected function setUp(): void
    {
        $this->mockDocument = $this->createMock(DocumentInterface::class);
        $this->command = new InsertParagraphMenuCommand($this->mockDocument);
    }
}
