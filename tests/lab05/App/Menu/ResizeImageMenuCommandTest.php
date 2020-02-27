<?php
declare(strict_types=1);

use Lab05\App\Menu\ResizeImageMenuCommand;
use Lab05\Document\DocumentInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ResizeImageMenuCommandTest extends TestCase
{
    private const POSITION = 0;
    private const WIDTH = 400;
    private const HEIGHT = 300;
    /** @var ResizeImageMenuCommand */
    private $command;
    /** @var DocumentInterface|MockObject */
    private $mockDocument;

    public function testThrowsExceptionIfEmptyArgs(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->command->execute('');
    }

    public function testCallDocumentResizeImageWithCorrectlyArgs(): void
    {
        $this->mockDocument->expects($this->once())->method('resizeImage')
            ->with(
                $this->equalTo(self::POSITION),
                $this->equalTo(self::WIDTH),
                $this->equalTo(self::HEIGHT)
            );
        $this->command->execute(self::POSITION . ' ' . self::WIDTH . ' ' . self::HEIGHT);
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
            [self::POSITION . ' ' . self::WIDTH . ' ' . ''],
            [self::POSITION . ' ' . self::WIDTH . ' ' . 'height'],
            [self::POSITION . ' ' . 'width' . ' ' . self::HEIGHT],
            ['start' . ' ' . self::WIDTH . ' ' . self::HEIGHT],
        ];
    }

    protected function setUp(): void
    {
        $this->mockDocument = $this->createMock(DocumentInterface::class);
        $this->command = new ResizeImageMenuCommand($this->mockDocument);
    }
}