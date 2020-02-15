<?php


use Lab04\Designer\Designer;
use Lab04\Shape\Shape;
use Lab04\Shape\ShapeFactoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DesignerTest extends TestCase
{
    private const DONE_COMMAND = 'done';
    /** @var Designer */
    private $designer;
    private $commandsBeforeDone = ['first', 'second', 'third'];
    private $commandsAfterDone = ['afterDoneFirst', 'afterDoneSecond', 'done', 'afterDoneThird'];
    /** @var SplTempFileObject */
    private $stdin;
    /** @var ShapeFactoryInterface|MockObject */
    private $shapeFactory;

    public function setUp(): void
    {
        $this->shapeFactory = $this->createMock(ShapeFactoryInterface::class);
        $this->designer = new Designer($this->shapeFactory);
        $this->stdin = new SplTempFileObject(-1);
        $this->stdin->fwrite(implode(PHP_EOL, array_merge($this->commandsBeforeDone, [self::DONE_COMMAND], $this->commandsAfterDone)));
    }

    public function testCreateDraft(): void
    {
        $consecutiveArray = array_map(function ($item) {
            return [$this->equalTo($item)];
        }, $this->commandsBeforeDone);

        $this->stdin->rewind();
        $this->shapeFactory->expects($this->exactly(count($this->commandsBeforeDone)))
            ->method('createShape')
            ->willReturn($this->createMock(Shape::class))
            ->withConsecutive(...$consecutiveArray);

        $this->designer->createDraft($this->stdin);
    }
}
