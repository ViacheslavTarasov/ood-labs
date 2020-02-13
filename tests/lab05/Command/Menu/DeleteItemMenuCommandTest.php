<?php
declare(strict_types=1);

use Lab05\Command\Menu\DeleteItemMenuCommand;
use Lab05\Document\DocumentInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteItemMenuCommandTest extends TestCase
{
    private const POSITION = 0;

    /** @var DeleteItemMenuCommand */
    private $command;
    /** @var DocumentInterface|MockObject */
    private $mockDocument;

    public function testCallDocumentDeleteItemWithCorrectlyArgs(): void
    {
        $this->mockDocument->expects($this->once())->method('deleteItem')->with($this->equalTo(self::POSITION));
        $this->command->execute((string)self::POSITION);
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
            [''],
            ['start'],
        ];
    }

    protected function setUp(): void
    {
        $this->mockDocument = $this->createMock(DocumentInterface::class);
        $this->command = new DeleteItemMenuCommand($this->mockDocument);
    }
}