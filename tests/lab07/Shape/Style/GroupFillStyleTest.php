<?php
declare(strict_types=1);


use Lab07\Color\RgbaColor;
use Lab07\Style\FillStyle;
use Lab07\Style\FillStyleIterableInterface;
use Lab07\Style\GroupFillStyle;
use PHPUnit\Framework\TestCase;

class GroupFillStyleTest extends TestCase
{
    public function testIsEnabledReturnsNullWhenFillStyleIteratorIsEmpty(): void
    {
        $groupFillStyle = $this->getGroupFillStyleWithEmptyFillStyleIterator();
        $this->assertNull($groupFillStyle->isEnabled());
    }

    public function testIsEnabledReturnsTrueWhenFillStyleIsEnabled(): void
    {
        $isEnabled = true;
        $groupFillStyle = $this->getGroupFillStyleWithSameFillStyle(new RgbaColor(1, 2, 3), $isEnabled);
        $this->assertTrue($groupFillStyle->isEnabled());
    }

    public function testIsEnabledReturnsFalseWhenFillStylesIsDisabled(): void
    {
        $isEnabled = false;
        $groupFillStyle = $this->getGroupFillStyleWithSameFillStyle(new RgbaColor(1, 2, 3), $isEnabled);
        $this->assertFalse($groupFillStyle->isEnabled());
    }

    public function testIsEnabledReturnsNullWhenFilStyleWithDifferentProperties(): void
    {
        $groupFillStyle = $this->getGroupFillStyleWithDifferentFillStyles();
        $this->assertNull($groupFillStyle->isEnabled());
    }

    public function testEnableCallsEnableForEveryFillStyle(): void
    {
        $styles = [];
        for ($i = 0; $i < 5; $i++) {
            $mockStyle = $this->createMock(FillStyle::class);
            $mockStyle->expects($this->once())->method('enable');
            $styles[] = $mockStyle;
        }
        $fillStyleIterable = $this->getFillStyleIterator($styles);
        $groupStyle = new GroupFillStyle($fillStyleIterable);
        $groupStyle->enable();
    }

    public function testSetColorCallsSetColorForEveryFillStyle(): void
    {
        $color = new RgbaColor(1, 2, 3, 10);
        $styles = [];
        for ($i = 0; $i < 5; $i++) {
            $mockStyle = $this->createMock(FillStyle::class);
            $mockStyle->expects($this->once())->method('setColor')->with($color);
            $styles[] = $mockStyle;
        }
        $fillStyleIterable = $this->getFillStyleIterator($styles);
        $groupStyle = new GroupFillStyle($fillStyleIterable);
        $groupStyle->setColor($color);
    }

    public function testGetColorReturnsNullWhenFillStyleIteratorIsEmpty(): void
    {
        $groupFillStyle = $this->getGroupFillStyleWithEmptyFillStyleIterator();
        $this->assertNull($groupFillStyle->getColor());
    }

    public function testGetColorReturnsColorWhenFillStylesWithSameColor(): void
    {
        $color = new RgbaColor(1, 2, 3);
        $groupFillStyle = $this->getGroupFillStyleWithSameFillStyle($color, true);
        $this->assertEquals($color, $groupFillStyle->getColor());
    }

    public function testGetColorReturnsNullWhenFillStylesWithDifferentColors(): void
    {
        $groupFillStyle = $this->getGroupFillStyleWithDifferentFillStyles();
        $this->assertNull($groupFillStyle->getColor());
    }


    private function getGroupFillStyleWithDifferentFillStyles(): GroupFillStyle
    {
        $styles = [
            new FillStyle(new RgbaColor(1, 2, 3), true),
            new FillStyle(new RgbaColor(3, 2, 1), false)
        ];
        $fillStyleIterable = $this->getFillStyleIterator($styles);
        return new GroupFillStyle($fillStyleIterable);
    }

    private function getGroupFillStyleWithSameFillStyle(RgbaColor $color, bool $enabled): GroupFillStyle
    {
        $styles = [
            new FillStyle($color, $enabled),
            new FillStyle($color, $enabled)
        ];
        $fillStyleIterable = $this->getFillStyleIterator($styles);
        return new GroupFillStyle($fillStyleIterable);
    }

    private function getGroupFillStyleWithEmptyFillStyleIterator(): GroupFillStyle
    {
        $fillStyleIterator = $this->getFillStyleIterator([]);
        return new GroupFillStyle($fillStyleIterator);
    }

    private function getFillStyleIterator(array $fillStyles): FillStyleIterableInterface
    {
        return new class($fillStyles) implements FillStyleIterableInterface
        {
            /** @var FillStyle[] */
            private $styles;

            public function __construct(array $fillStyles)
            {
                $this->styles = $fillStyles;
            }

            public function iterateFillStyle(\Closure $closure): void
            {
                foreach ($this->styles as $style) {
                    $closure($style);
                }
            }
        };
    }
}
