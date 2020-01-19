<?php
declare(strict_types=1);

use Lab04\Canvas\CanvasInterface;
use Lab04\Painter\Painter;
use Lab04\PictureDraft\PictureDraft;
use Lab04\Shape\ShapeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PainterTest extends TestCase
{
    private const SHAPES_COUNT = 5;
    /** @var Painter */
    private $painter;

    public function setUp(): void
    {
        $this->painter = new Lab04\Painter\Painter();
    }

    public function testDrawPicture(): void
    {
        /** @var ShapeInterface|MockObject $shape */
        $shape = $this->createMock(ShapeInterface::class);
        /** @var CanvasInterface|MockObject $canvas */
        $canvas = $this->createMock(CanvasInterface::class);
        /** @var PictureDraft|MockObject $pictureDraft */
        $pictureDraft = $this->createMock(PictureDraft::class);


        $pictureDraft->expects($this->exactly(1))
            ->method('getShapeCount')->willReturn(self::SHAPES_COUNT);

        $pictureDraft->expects($this->exactly(self::SHAPES_COUNT))
            ->method('getShape')
            ->willReturn($shape);

        $shape->expects($this->exactly(self::SHAPES_COUNT))
            ->method('draw')
            ->with($canvas);

        $this->painter->drawPicture($pictureDraft, $canvas);
    }
}
