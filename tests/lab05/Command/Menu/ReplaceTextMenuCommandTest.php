<?php
declare(strict_types=1);

use Lab05\Command\Menu\ReplaceTextMenuCommand;
use Lab05\Document\DocumentInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ReplaceTextMenuCommandTest extends TestCase
{
    private const POSITION = 0;
    private const TEXT = 'test text';
    /** @var ReplaceTextMenuCommand */
    private $command;
    /** @var DocumentInterface|MockObject */
    private $mockDocument;

    public function testThrowsExceptionIfEmptyArgs(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->command->execute('');
    }

    public function testCallDocumentReplaceWithCorrectlyArgs(): void
    {
        $this->mockDocument->expects($this->once())->method('replaceText')
            ->with(
                $this->equalTo(self::TEXT),
                $this->equalTo(self::POSITION)
            );
        $this->command->execute(self::POSITION . ' ' . self::TEXT);
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
        $this->command = new ReplaceTextMenuCommand($this->mockDocument);
    }
}