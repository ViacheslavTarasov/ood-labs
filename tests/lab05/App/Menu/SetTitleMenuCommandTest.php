<?php
declare(strict_types=1);

use Lab05\App\Menu\SetTitleMenuCommand;
use Lab05\Document\DocumentInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SetTitleMenuCommandTest extends TestCase
{
    private const TEXT = 'test text';
    /** @var SetTitleMenuCommand */
    private $command;
    /** @var DocumentInterface|MockObject */
    private $mockDocument;

    public function testCalledSetTitleWhenExecute(): void
    {
        $this->mockDocument->expects($this->once())->method('setTitle');
        $this->command->execute('');
    }

    /**
     * @dataProvider dataProvider
     * @param string $title
     */
    public function testCallDocumentSetTitleWithCorrectlyArgs(string $title): void
    {
        $this->mockDocument->expects($this->once())->method('setTitle')->with($this->equalTo($title));
        $this->command->execute($title);
    }


    public function dataProvider(): array
    {
        return [
            [''],
            [self::TEXT],
        ];
    }

    protected function setUp(): void
    {
        $this->mockDocument = $this->createMock(DocumentInterface::class);
        $this->command = new SetTitleMenuCommand($this->mockDocument);
    }
}