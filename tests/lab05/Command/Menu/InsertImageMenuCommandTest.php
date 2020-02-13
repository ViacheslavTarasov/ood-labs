<?php
declare(strict_types=1);

use Lab05\Command\Menu\InsertImageMenuCommand;
use Lab05\Document\DocumentInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class InsertImageMenuCommandTest extends TestCase
{
    private const POSITION = 0;
    private const POSITION_END = 'end';
    private const WIDTH = 400;
    private const HEIGHT = 300;
    private const PATH = 'test.png';
    /** @var InsertImageMenuCommand */
    private $command;
    /** @var DocumentInterface|MockObject */
    private $mockDocument;

    public function testThrowsExceptionIfEmptyArgs(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->command->execute('');
    }

    public function testCallDocumentInsertImageWithCorrectlyArgs(): void
    {
        $this->mockDocument->expects($this->once())->method('insertImage')
            ->with(
                $this->equalTo(self::PATH),
                $this->equalTo(self::WIDTH),
                $this->equalTo(self::HEIGHT),
                $this->equalTo(self::POSITION)
            );
        $this->command->execute(self::POSITION . ' ' . self::WIDTH . ' ' . self::HEIGHT . ' ' . self::PATH);
    }

    public function testCallDocumentInsertImageWithCorrectlyArgsIfEndPosition(): void
    {
        $this->mockDocument->expects($this->once())->method('insertImage')
            ->with(
                $this->equalTo(self::PATH),
                $this->equalTo(self::WIDTH),
                $this->equalTo(self::HEIGHT),
                $this->equalTo(NULL)
            );
        $this->command->execute(self::POSITION_END . ' ' . self::WIDTH . ' ' . self::HEIGHT . ' ' . self::PATH);
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
            [self::POSITION . ' ' . self::WIDTH . ' ' . self::HEIGHT . ' ' . ''],
            [self::POSITION . ' ' . self::WIDTH . ' ' . 'height' . ' ' . self::PATH],
            [self::POSITION . ' ' . 'width' . ' ' . self::HEIGHT . ' ' . self::PATH],
            ['start' . ' ' . self::WIDTH . ' ' . self::HEIGHT . ' ' . self::PATH],
        ];
    }

    protected function setUp(): void
    {
        $this->mockDocument = $this->createMock(DocumentInterface::class);
        $this->command = new InsertImageMenuCommand($this->mockDocument);
    }
}
