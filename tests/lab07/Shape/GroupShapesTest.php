<?php
declare(strict_types=1);

use Lab07\Canvas\CanvasInterface;
use Lab07\Shape\Frame;
use Lab07\Shape\GroupShapes;
use Lab07\Shape\NotFoundException;
use Lab07\Shape\Point;
use Lab07\Shape\ShapeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GroupShapesTest extends TestCase
{
    /** @var GroupShapes */
    private $groupShapes;

    public function testGetGroupReturnsSelf(): void
    {
        $this->assertTrue($this->groupShapes === $this->groupShapes->getGroup());
    }

    public function testGetShapeCountReturns0IfNotAddedItems(): void
    {
        $this->assertEquals(0, $this->groupShapes->getShapeCount());
    }

    public function testInsertShapeIncreaseShapeCount(): void
    {
        $mockShape1 = $this->createMock(ShapeInterface::class);
        $mockShape2 = $this->createMock(ShapeInterface::class);

        $this->groupShapes->insertShape($mockShape1, 0);
        $this->assertEquals(1, $this->groupShapes->getShapeCount());
        $this->groupShapes->insertShape($mockShape2, 1);
        $this->assertEquals(2, $this->groupShapes->getShapeCount());
    }

    public function testInsertShapeInNegativePositionThrowsException(): void
    {
        $mockShape = $this->createMock(ShapeInterface::class);
        $this->expectException(InvalidArgumentException::class);
        $this->groupShapes->insertShape($mockShape, -1);
    }

    public function testInsertShapeThrowsExceptionIfPositionMoreThanShapesCount(): void
    {
        $mockShape = $this->createMock(ShapeInterface::class);
        $this->expectException(InvalidArgumentException::class);
        $this->groupShapes->insertShape($mockShape, 1);
    }

    public function testGetShapeAtIndexThrowsExceptionWhenShapeNotAdded(): void
    {
        $this->expectException(NotFoundException::class);
        $this->assertNull($this->groupShapes->getShapeAtIndex(0));
    }

    public function testGetShapeAtIndexReturnsRightShape(): void
    {
        $mockShape1 = $this->createMock(ShapeInterface::class);
        $mockShape2 = $this->createMock(ShapeInterface::class);
        $mockShape3 = $this->createMock(ShapeInterface::class);

        $this->groupShapes->insertShape($mockShape1, 0);
        $this->groupShapes->insertShape($mockShape2, 1);
        $this->groupShapes->insertShape($mockShape3, 1);

        $this->assertTrue($mockShape1 === $this->groupShapes->getShapeAtIndex(0));
        $this->assertTrue($mockShape2 === $this->groupShapes->getShapeAtIndex(2));
        $this->assertTrue($mockShape3 === $this->groupShapes->getShapeAtIndex(1));

    }

    public function testRemoveAtIndexDecreaseShapesCount(): void
    {
        $this->groupShapes->insertShape($this->createMock(ShapeInterface::class), 0);
        $this->groupShapes->insertShape($this->createMock(ShapeInterface::class), 0);

        $this->groupShapes->removeShapeAtIndex(1);
        $this->assertEquals(1, $this->groupShapes->getShapeCount());

        $this->groupShapes->removeShapeAtIndex(0);
        $this->assertEquals(0, $this->groupShapes->getShapeCount());
    }

    public function testRemoveAtIndexThrowsExceptionWhenShapesNotAdded(): void
    {
        $this->expectException(NotFoundException::class);
        $this->groupShapes->removeShapeAtIndex(0);
    }

    public function testRemoveAtIndexThrowsExceptionWhenInvalidIndex(): void
    {
        $this->groupShapes->insertShape($this->createMock(ShapeInterface::class), 0);
        $this->expectException(NotFoundException::class);
        $this->groupShapes->removeShapeAtIndex(1);
    }

    public function testRemoveAtIndexDoesNotRemoveOtherShapesAndNextShapesAreShifted(): void
    {
        $mockShape1 = $this->createMock(ShapeInterface::class);
        $mockShape2 = $this->createMock(ShapeInterface::class);
        $mockShape3 = $this->createMock(ShapeInterface::class);

        $this->groupShapes->insertShape($mockShape1, 0);
        $this->groupShapes->insertShape($mockShape2, 1);
        $this->groupShapes->insertShape($mockShape3, 1);

        $this->groupShapes->removeShapeAtIndex(1);

        $this->assertEquals(2, $this->groupShapes->getShapeCount());
        $this->assertTrue($mockShape1 === $this->groupShapes->getShapeAtIndex(0));
        $this->assertTrue($mockShape2 === $this->groupShapes->getShapeAtIndex(1));
    }

    public function testDrawCallsDrawForEveryShapeWithCanvas(): void
    {
        $canvas = $this->createMock(CanvasInterface::class);
        for ($i = 0; $i < 5; $i++) {
            $mockShape = $this->createMock(ShapeInterface::class);
            $mockShape->expects($this->once())->method('draw')->with($canvas);
            $this->groupShapes->insertShape($mockShape, $i);
        }
        $this->groupShapes->draw($canvas);
    }

    public function testGetFrameReturnsNullWhenShapesNotAdded(): void
    {
        $this->assertNull($this->groupShapes->getFrame());
    }

    public function testGetFrameReturnsNullWhenEmptyGroupShapesAdded(): void
    {
        $emptyGroupShapes = $this->createMock(GroupShapes::class);
        $this->groupShapes->insertShape($emptyGroupShapes, 0);
        $this->assertNull($this->groupShapes->getFrame());
    }

    public function testGetFrameReturnsFrameCoveringAllFramesOfAddedShapes(): void
    {
        $frame1 = $this->getFrame(10, 15, 100, 150);
        $frame2 = $this->getFrame(5, 20, 50, 200);

        $expectedFrame = $this->getFrame(5, 15, 100, 200);

        $shape1 = $this->createMockShapeWithFrame($frame1);
        $shape2 = $this->createMockShapeWithFrame($frame2);

        $this->groupShapes->insertShape($shape1, 0);
        $this->groupShapes->insertShape($shape2, 1);

        $this->assertEquals($expectedFrame, $this->groupShapes->getFrame());
    }

    public function testShouldNotAffectFrameOfTheGroupIfAddedShapeWithNullFrame(): void
    {
        $frame = $this->getFrame(10, 20, 100, 200);
        $shape1 = $this->createMockShapeWithFrame($frame);
        $shape2 = $this->createMockShapeWithFrame(null);
        $this->groupShapes->insertShape($shape1, 0);
        $this->groupShapes->insertShape($shape2, 1);

        $this->assertEquals($frame, $this->groupShapes->getFrame());
    }

    public function testSetFrameDoesNotResizeEmptyGroup(): void
    {
        $frame = $this->getFrame(10, 20, 100, 200);
        $this->groupShapes->setFrame($frame);
        $this->assertEquals(null, $this->groupShapes->getFrame());
    }

    public function testSetFrameCallsSetFrameForEveryAddedShape(): void
    {
        $newGroupFrame = $this->getFrame(110, 220, 400, 600);
        for ($i = 0; $i < 5; $i++) {
            $frame = $this->getFrame(10, 20, 100, 200);
            $mockShape = $this->createMockShapeWithFrame($frame);
            $mockShape->expects($this->once())->method('setFrame');
            $this->groupShapes->insertShape($mockShape, $i);
        }
        $this->groupShapes->setFrame($newGroupFrame);
    }

    public function testSetFrameWithSameFrameDoesNotResizeShape(): void
    {
        $oldShapeFrame = $this->getFrame(100, 200, 200, 400);
        $expectedShapeFrame = $this->getFrame(100, 200, 200, 400);

        $mockShape = $this->createMockShapeWithFrame($oldShapeFrame);
        $mockShape->expects($this->once())->method('setFrame')->with($expectedShapeFrame);

        $this->groupShapes->insertShape($mockShape, 0);
        $this->groupShapes->setFrame($oldShapeFrame);
    }

    public function testSetFrameResizesShapeProportionallyWhenOneShapeAdded(): void
    {

        $oldShapeFrame = $this->getFrame(100, 200, 200, 400);
        $newGroupFrame = $this->getFrame(200, 300, 400, 600);
        $expectedShapeFrame = $this->getFrame(200, 300, 400, 600);

        $mockShape = $this->createMockShapeWithFrame($oldShapeFrame);
        $mockShape->expects($this->once())->method('setFrame')->with($expectedShapeFrame);

        $this->groupShapes->insertShape($mockShape, 0);
        $this->groupShapes->setFrame($newGroupFrame);
    }

    public function testSetFrameResizesAllShapesProportionally(): void
    {
        $oldFrame1 = $this->getFrame(100, 200, 200, 450);
        $oldFrame2 = $this->getFrame(150, 150, 250, 300);

        $newGroupFrame = $this->getFrame(200, 200, 500, 800);

        $expectedFrame1 = $this->getFrame(200, 300, 400, 800);
        $expectedFrame2 = $this->getFrame(300, 200, 500, 500);

        $mockShape1 = $this->createMockShapeWithFrame($oldFrame1);
        $mockShape1->expects($this->once())->method('setFrame')->with($expectedFrame1);

        $mockShape2 = $this->createMockShapeWithFrame($oldFrame2);
        $mockShape2->expects($this->once())->method('setFrame')->with($expectedFrame2);

        $this->groupShapes->insertShape($mockShape1, 0);
        $this->groupShapes->insertShape($mockShape2, 1);

        $this->groupShapes->setFrame($newGroupFrame);
    }

    private function getFrame(int $leftTopX, int $leftTopY, int $rightBottomX, int $rightBottomY): Frame
    {
        return new Frame(new Point($leftTopX, $leftTopY), $rightBottomX - $leftTopX, $rightBottomY - $leftTopY);
    }

    /**
     * @param Frame|null $frame
     * @return ShapeInterface|MockObject
     */
    private function createMockShapeWithFrame(?Frame $frame): ShapeInterface
    {
        $shape = $this->createMock(ShapeInterface::class);
        $shape->method('getFrame')->willReturn($frame);

        return $shape;
    }

    protected function setUp(): void
    {
        $this->groupShapes = new GroupShapes();
    }
}
