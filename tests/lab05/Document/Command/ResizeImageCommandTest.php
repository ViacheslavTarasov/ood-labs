<?php
declare(strict_types=1);

use Lab05\Document\Command\ChangeTextCommand;
use Lab05\Document\Command\ResizeImageCommand;
use Lab05\Document\ImageInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ResizeImageCommandTest extends TestCase
{
    private const WIDTH_BEFORE = 100;
    private const HEIGHT_BEFORE = 200;
    private const WIDTH_AFTER = 300;
    private const HEIGHT_AFTER = 400;

    /** @var ChangeTextCommand */
    private $command;
    /** @var ImageInterface|MockObject */
    private $mockImage;

    public function testExecuteWillCallImageMethodsWithCorrectlyParams(): void
    {
        $this->mockImage->expects($this->once())->method('getWidth')->willReturn(self::WIDTH_BEFORE);
        $this->mockImage->expects($this->once())->method('getHeight')->willReturn(self::HEIGHT_BEFORE);
        $this->mockImage->expects($this->once())->method('resize')->with(self::WIDTH_AFTER, self::HEIGHT_AFTER);
        $this->command->execute();
    }

    public function testExecuteAndUnexecuteWillCallImageMethodsWithCorrectlyParams(): void
    {
        $this->mockImage->expects($this->exactly(2))->method('getWidth')
            ->willReturn(self::WIDTH_BEFORE, self::WIDTH_AFTER);
        $this->mockImage->expects($this->exactly(2))->method('getHeight')
            ->willReturn(self::HEIGHT_BEFORE, self::HEIGHT_AFTER);
        $this->mockImage->expects($this->exactly(2))->method('resize')
            ->withConsecutive(
                [self::WIDTH_AFTER, self::HEIGHT_AFTER],
                [self::WIDTH_BEFORE, self::HEIGHT_BEFORE]
            );
        $this->command->execute();
        $this->command->unexecute();
    }

    public function testNothingWillHappenIfCallUnexecuteFirst(): void
    {
        $this->mockImage->expects($this->exactly(0))->method('resize');
        $this->command->unexecute();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockImage = $this->createMock(ImageInterface::class);
        $this->command = new ResizeImageCommand($this->mockImage, self::WIDTH_AFTER, self::HEIGHT_AFTER);
    }
}
