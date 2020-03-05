<?php
declare(strict_types=1);

use Lab07\Shape\RgbaColor;
use Lab07\Shape\ShapeInterface;
use Lab07\Shape\Style\GroupLineStyle;
use Lab07\Shape\Style\LineStyle;
use PHPUnit\Framework\TestCase;

class GroupLineStyleTest extends TestCase
{
    public function testGetThicknessReturnsNullWhenShapesIsEmpty(): void
    {
        $groupLineStyle = $this->getGroupLineStyleWithEmptyShapes();
        $this->assertNull($groupLineStyle->getColor());
    }

    public function testGetThicknessReturnsColorWhenShapesLineStylesWithSameColor(): void
    {
        $thickness = 3;
        $groupLineStyle = $this->getGroupLineStyleWithSameShapesLineStyle(new RgbaColor(1, 2, 3), true, $thickness);
        $this->assertEquals($thickness, $groupLineStyle->getThickness());
    }

    public function testGetThicknessReturnsNullWhenShapesLineStylesWithDifferentColors(): void
    {
        $groupLineStyle = $this->getGroupLineStyleWithDifferentShapesLineStyle();
        $this->assertNull($groupLineStyle->getThickness());
    }

    public function testIsEnabledReturnsTrueWhenShapesIsEmpty(): void
    {
        $groupLineStyle = $this->getGroupLineStyleWithEmptyShapes();
        $this->assertTrue($groupLineStyle->isEnabled());
    }

    public function testIsEnabledReturnsTrueWhenShapesLineStyleIsEnabled(): void
    {
        $isEnabled = true;
        $groupLineStyle = $this->getGroupLineStyleWithSameShapesLineStyle(new RgbaColor(1, 2, 3), $isEnabled);
        $this->assertTrue($groupLineStyle->isEnabled());
    }

    public function testIsEnabledReturnsFalseWhenShapesLineStyleIsDisabled(): void
    {
        $isEnabled = false;
        $groupLineStyle = $this->getGroupLineStyleWithSameShapesLineStyle(new RgbaColor(1, 2, 3), $isEnabled);
        $this->assertFalse($groupLineStyle->isEnabled());
    }


    public function testIsEnabledReturnsFalseWhenShapesWithDifferentFilStyleProperties(): void
    {
        $groupLineStyle = $this->getGroupLineStyleWithDifferentShapesLineStyle();
        $this->assertFalse($groupLineStyle->isEnabled());
    }

    public function testEnableCallsEnableForEveryLineStyle(): void
    {
        $shapes = [];
        for ($i = 0; $i < 5; $i++) {
            $mockStyle = $this->createMock(LineStyle::class);
            $mockStyle->expects($this->once())->method('enable');
            $mockShape = $this->createMockShapeWithLineStyle($mockStyle);
            $shapes[] = $mockShape;
        }
        $groupStyle = new GroupLineStyle($shapes);
        $groupStyle->enable();
    }

    public function testSetColorCallsSetColorForEveryLineStyle(): void
    {
        $shapes = [];
        $color = new RgbaColor(1, 2, 3, 10);
        for ($i = 0; $i < 5; $i++) {
            $mockStyle = $this->createMock(LineStyle::class);
            $mockStyle->expects($this->once())->method('setColor')->with($color);
            $mockShape = $this->createMockShapeWithLineStyle($mockStyle);
            $shapes[] = $mockShape;
        }
        $groupStyle = new GroupLineStyle($shapes);
        $groupStyle->setColor($color);
    }

    public function testGetColorReturnsNullWhenShapesIsEmpty(): void
    {
        $groupLineStyle = $this->getGroupLineStyleWithEmptyShapes();
        $this->assertNull($groupLineStyle->getColor());
    }

    public function testGetColorReturnsColorWhenShapesLineStylesWithSameColor(): void
    {
        $color = new RgbaColor(1, 2, 3);
        $groupLineStyle = $this->getGroupLineStyleWithSameShapesLineStyle($color, true);
        $this->assertEquals($color, $groupLineStyle->getColor());
    }

    public function testGetColorReturnsNullWhenShapesLineStylesWithDifferentColors(): void
    {
        $groupLineStyle = $this->getGroupLineStyleWithDifferentShapesLineStyle();
        $this->assertNull($groupLineStyle->getColor());
    }


    private function getGroupLineStyleWithDifferentShapesLineStyle(): GroupLineStyle
    {
        $lineStyle1 = new LineStyle(new RgbaColor(1, 2, 3), true, 1);
        $lineStyle2 = new LineStyle(new RgbaColor(3, 2, 1), false, 2);

        $shapes = [
            $this->createMockShapeWithLineStyle($lineStyle1),
            $this->createMockShapeWithLineStyle($lineStyle2),
        ];
        return new GroupLineStyle($shapes);
    }

    private function getGroupLineStyleWithSameShapesLineStyle(RgbaColor $color, bool $enabled, $thickness = 1): GroupLineStyle
    {
        $lineStyle1 = new LineStyle($color, $enabled, $thickness);
        $lineStyle2 = new LineStyle($color, $enabled, $thickness);

        $shapes = [
            $this->createMockShapeWithLineStyle($lineStyle1),
            $this->createMockShapeWithLineStyle($lineStyle2),
        ];
        return new GroupLineStyle($shapes);
    }

    private function getGroupLineStyleWithEmptyShapes(): GroupLineStyle
    {
        $shapes = [];
        return new GroupLineStyle($shapes);
    }

    private function createMockShapeWithLineStyle(LineStyle $lineStyle): ShapeInterface
    {
        $shape = $this->createMock(ShapeInterface::class);
        $shape->method('getLineStyle')->willReturn($lineStyle);

        return $shape;
    }
}
