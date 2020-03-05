<?php
declare(strict_types=1);


use Lab07\Shape\RgbaColor;
use Lab07\Shape\ShapeInterface;
use Lab07\Shape\Style\FillStyle;
use Lab07\Shape\Style\GroupFillStyle;
use PHPUnit\Framework\TestCase;

class GroupFillStyleTest extends TestCase
{
    public function testIsEnabledReturnsTrueWhenShapesIsEmpty(): void
    {
        $groupFillStyle = $this->getGroupFillStyleWithEmptyShapes();
        $this->assertTrue($groupFillStyle->isEnabled());
    }

    public function testIsEnabledReturnsTrueWhenShapesFillStyleIsEnabled(): void
    {
        $isEnabled = true;
        $groupFillStyle = $this->getGroupFillStyleWithSameShapesFillStyle(new RgbaColor(1, 2, 3), $isEnabled);
        $this->assertTrue($groupFillStyle->isEnabled());
    }

    public function testIsEnabledReturnsFalseWhenShapesFillStyleIsDisabled(): void
    {
        $isEnabled = false;
        $groupFillStyle = $this->getGroupFillStyleWithSameShapesFillStyle(new RgbaColor(1, 2, 3), $isEnabled);
        $this->assertFalse($groupFillStyle->isEnabled());
    }


    public function testIsEnabledReturnsFalseWhenShapesWithDifferentFilStyleProperties(): void
    {
        $groupFillStyle = $this->getGroupFillStyleWithDifferentShapesFillStyle();
        $this->assertFalse($groupFillStyle->isEnabled());
    }

    public function testEnableCallsEnableForEveryFillStyle(): void
    {
        $shapes = [];
        for ($i = 0; $i < 5; $i++) {
            $mockStyle = $this->createMock(FillStyle::class);
            $mockStyle->expects($this->once())->method('enable');
            $mockShape = $this->createMockShapeWithFillStyle($mockStyle);
            $shapes[] = $mockShape;
        }
        $groupStyle = new GroupFillStyle($shapes);
        $groupStyle->enable();
    }

    public function testSetColorCallsSetColorForEveryFillStyle(): void
    {
        $shapes = [];
        $color = new RgbaColor(1, 2, 3, 10);
        for ($i = 0; $i < 5; $i++) {
            $mockStyle = $this->createMock(FillStyle::class);
            $mockStyle->expects($this->once())->method('setColor')->with($color);
            $mockShape = $this->createMockShapeWithFillStyle($mockStyle);
            $shapes[] = $mockShape;
        }
        $groupStyle = new GroupFillStyle($shapes);
        $groupStyle->setColor($color);
    }

    public function testGetColorReturnsNullWhenShapesIsEmpty(): void
    {
        $groupFillStyle = $this->getGroupFillStyleWithEmptyShapes();
        $this->assertNull($groupFillStyle->getColor());
    }

    public function testGetColorReturnsColorWhenShapesFillStylesWithSameColor(): void
    {
        $color = new RgbaColor(1, 2, 3);
        $groupFillStyle = $this->getGroupFillStyleWithSameShapesFillStyle($color, true);
        $this->assertEquals($color, $groupFillStyle->getColor());
    }

    public function testGetColorReturnsNullWhenShapesFillStylesWithDifferentColors(): void
    {
        $groupFillStyle = $this->getGroupFillStyleWithDifferentShapesFillStyle();
        $this->assertNull($groupFillStyle->getColor());
    }


    private function getGroupFillStyleWithDifferentShapesFillStyle(): GroupFillStyle
    {
        $fillStyle1 = new FillStyle(new RgbaColor(1, 2, 3), true);
        $fillStyle2 = new FillStyle(new RgbaColor(3, 2, 1), false);

        $shapes = [
            $this->createMockShapeWithFillStyle($fillStyle1),
            $this->createMockShapeWithFillStyle($fillStyle2),
        ];
        return new GroupFillStyle($shapes);
    }

    private function getGroupFillStyleWithSameShapesFillStyle(RgbaColor $color, bool $enabled): GroupFillStyle
    {
        $fillStyle1 = new FillStyle($color, $enabled);
        $fillStyle2 = new FillStyle($color, $enabled);

        $shapes = [
            $this->createMockShapeWithFillStyle($fillStyle1),
            $this->createMockShapeWithFillStyle($fillStyle2),
        ];
        return new GroupFillStyle($shapes);
    }

    private function getGroupFillStyleWithEmptyShapes(): GroupFillStyle
    {
        $shapes = [];
        return new GroupFillStyle($shapes);
    }

    private function createMockShapeWithFillStyle(FillStyle $fillStyle): ShapeInterface
    {
        $shape = $this->createMock(ShapeInterface::class);
        $shape->method('getFillStyle')->willReturn($fillStyle);

        return $shape;
    }
}
