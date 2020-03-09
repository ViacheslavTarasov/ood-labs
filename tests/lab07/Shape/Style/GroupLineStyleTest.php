<?php
declare(strict_types=1);

use Lab07\Color\RgbaColor;
use Lab07\Style\GroupLineStyle;
use Lab07\Style\LineStyle;
use Lab07\Style\LineStyleIterable;
use PHPUnit\Framework\TestCase;

class GroupLineStyleTest extends TestCase
{
    public function testIsEnabledReturnsNullWhenLineStyleIteratorIsEmpty(): void
    {
        $groupLineStyle = $this->getGroupLineStyleWithEmptyLineStyleIterator();
        $this->assertNull($groupLineStyle->isEnabled());
    }

    public function testIsEnabledReturnsTrueWhenLineStyleIsEnabled(): void
    {
        $isEnabled = true;
        $groupLineStyle = $this->getGroupLineStyleWithSameLineStyle(new RgbaColor(1, 2, 3), $isEnabled);
        $this->assertTrue($groupLineStyle->isEnabled());
    }

    public function testIsEnabledReturnsFalseWhenLineStylesIsDisabled(): void
    {
        $isEnabled = false;
        $groupLineStyle = $this->getGroupLineStyleWithSameLineStyle(new RgbaColor(1, 2, 3), $isEnabled);
        $this->assertFalse($groupLineStyle->isEnabled());
    }

    public function testIsEnabledReturnsNullWhenFilStyleWithDifferentProperties(): void
    {
        $groupLineStyle = $this->getGroupLineStyleWithDifferentLineStyles();
        $this->assertNull($groupLineStyle->isEnabled());
    }

    public function testEnableCallsEnableForEveryLineStyle(): void
    {
        $styles = [];
        for ($i = 0; $i < 5; $i++) {
            $mockStyle = $this->createMock(LineStyle::class);
            $mockStyle->expects($this->once())->method('enable');
            $styles[] = $mockStyle;
        }
        $lineStyleIterable = $this->getLineStyleIterator($styles);
        $groupStyle = new GroupLineStyle($lineStyleIterable);
        $groupStyle->enable();
    }

    public function testSetColorCallsSetColorForEveryLineStyle(): void
    {
        $color = new RgbaColor(1, 2, 3, 10);
        $styles = [];
        for ($i = 0; $i < 5; $i++) {
            $mockStyle = $this->createMock(LineStyle::class);
            $mockStyle->expects($this->once())->method('setColor')->with($color);
            $styles[] = $mockStyle;
        }
        $lineStyleIterable = $this->getLineStyleIterator($styles);
        $groupStyle = new GroupLineStyle($lineStyleIterable);
        $groupStyle->setColor($color);
    }

    public function testGetColorReturnsNullWhenLineStyleIteratorIsEmpty(): void
    {
        $groupLineStyle = $this->getGroupLineStyleWithEmptyLineStyleIterator();
        $this->assertNull($groupLineStyle->getColor());
    }

    public function testGetColorReturnsExpectedColorWhenLineStylesWithSameColor(): void
    {
        $color = new RgbaColor(1, 2, 3);
        $groupLineStyle = $this->getGroupLineStyleWithSameLineStyle($color, true);
        $this->assertEquals($color, $groupLineStyle->getColor());
    }

    public function testGetColorReturnsNullWhenLineStylesWithDifferentColors(): void
    {
        $groupLineStyle = $this->getGroupLineStyleWithDifferentLineStyles();
        $this->assertNull($groupLineStyle->getColor());
    }

    public function testGetThicknessReturnsNullWhenLineStyleIteratorIsEmpty(): void
    {
        $groupLineStyle = $this->getGroupLineStyleWithEmptyLineStyleIterator();
        $this->assertNull($groupLineStyle->getColor());
    }

    public function testGetThicknessReturnsExpectedValueWhenLineStylesWithSameThickness(): void
    {
        $thickness = 3;
        $groupLineStyle = $this->getGroupLineStyleWithSameLineStyle(new RgbaColor(1, 2, 3), true, $thickness);
        $this->assertEquals($thickness, $groupLineStyle->getThickness());
    }

    public function testGetThicknessReturnsNullWhenShapesLineStylesWithDifferentThickness(): void
    {
        $groupLineStyle = $this->getGroupLineStyleWithDifferentLineStyles();
        $this->assertNull($groupLineStyle->getThickness());
    }

    private function getGroupLineStyleWithDifferentLineStyles(): GroupLineStyle
    {
        $styles = [
            new LineStyle(new RgbaColor(1, 2, 3), true, 2),
            new LineStyle(new RgbaColor(3, 2, 1), false, 3)
        ];
        $lineStyleIterable = $this->getLineStyleIterator($styles);
        return new GroupLineStyle($lineStyleIterable);
    }

    private function getGroupLineStyleWithSameLineStyle(RgbaColor $color, bool $enabled, int $thickness = 1): GroupLineStyle
    {
        $styles = [
            new LineStyle($color, $enabled, $thickness),
            new LineStyle($color, $enabled, $thickness)
        ];
        $lineStyleIterable = $this->getLineStyleIterator($styles);
        return new GroupLineStyle($lineStyleIterable);
    }

    private function getGroupLineStyleWithEmptyLineStyleIterator(): GroupLineStyle
    {
        $lineStyleIterator = $this->getLineStyleIterator([]);
        return new GroupLineStyle($lineStyleIterator);
    }

    private function getLineStyleIterator(array $lineStyles): LineStyleIterable
    {
        return new class($lineStyles) implements LineStyleIterable
        {
            /** @var LineStyle[] */
            private $styles;

            public function __construct(array $lineStyles)
            {
                $this->styles = $lineStyles;
            }

            public function iterateLineStyle(\Closure $closure): void
            {
                foreach ($this->styles as $style) {
                    $closure($style);
                }
            }
        };
    }
}
