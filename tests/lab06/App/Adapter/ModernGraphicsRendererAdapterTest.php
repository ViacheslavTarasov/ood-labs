<?php
declare(strict_types=1);

use Lab06\App\Adapter\ModernGraphicsRendererAdapter;
use Lab06\App\Adapter\ModernGraphicsRendererClassAdapter;
use Lab06\ModernGraphicsLib\HexToRgbaConverter;
use Lab06\ModernGraphicsLib\ModernGraphicsRenderer;
use Lab06\ModernGraphicsLib\RgbaColor;
use PHPUnit\Framework\TestCase;

class ModernGraphicsRendererAdapterTest extends TestCase
{
    private const FROM_X = 50;
    private const FROM_Y = 70;
    private const TO_X = 150;
    private const TO_Y = 250;
    private const COLOR_HEX = '#336699';

    /** @var ModernGraphicsRendererAdapter */
    private $rendererAdapter;
    /** @var SplTempFileObject */
    private $stdout;
    /** @var RgbaColor */
    private $color;
    /** @var HexToRgbaConverter */
    private $hexToRgbaConverter;

    public function testWrittenDrawInStdoutAfterInit(): void
    {
        $this->stdout->rewind();
        $this->assertEquals('<draw>' . PHP_EOL, $this->stdout->fgets());
        $this->assertTrue($this->isStdoutEof());
    }

    public function testWrittenEndDrawInStdoutAfterDestruct(): void
    {
        unset($this->rendererAdapter);
        $this->stdout->rewind();
        $this->assertEquals('<draw>' . PHP_EOL, $this->stdout->fgets());
        $this->assertEquals('</draw>' . PHP_EOL, $this->stdout->fgets());
        $this->assertTrue($this->isStdoutEof());
    }

    public function testNothingWrittenAfterMoveTo(): void
    {
        $this->rendererAdapter->moveTo(self::FROM_X, self::FROM_Y);
        $this->stdout->rewind();
        $this->assertEquals('<draw>' . PHP_EOL, $this->stdout->fgets());
        $this->assertTrue($this->isStdoutEof());
    }

    public function testWrittenWhenCallsLineToWithoutMoveTo(): void
    {
        $this->rendererAdapter->lineTo(self::TO_X, self::TO_Y);
        $this->checkLineAssertion(0, 0, self::TO_X, self::TO_Y, $this->color);
    }

    public function testWrittenInStdoutWhenMoveToAndLineTo(): void
    {
        $this->rendererAdapter->moveTo(self::FROM_X, self::FROM_Y);
        $this->rendererAdapter->lineTo(self::TO_X, self::TO_Y);
        $this->checkLineAssertion(self::FROM_X, self::FROM_Y, self::TO_X, self::TO_Y, $this->color);
    }

    public function testSetColorShouldChangeColorLine(): void
    {
        $color = $this->hexToRgbaConverter->createRgbaFromHexString(self::COLOR_HEX);
        $this->rendererAdapter->setColor(self::COLOR_HEX);

        $this->rendererAdapter->moveTo(self::FROM_X, self::FROM_Y);
        $this->rendererAdapter->lineTo(self::TO_X, self::TO_Y);

        $this->checkLineAssertion(self::FROM_X, self::FROM_Y, self::TO_X, self::TO_Y, $color);
    }

    protected function setUp(): void
    {
        $this->stdout = new SplTempFileObject();
        $this->rendererAdapter = new ModernGraphicsRendererAdapter(New ModernGraphicsRenderer($this->stdout));
        $this->hexToRgbaConverter = new HexToRgbaConverter();
        $this->color = $this->hexToRgbaConverter->createRgbaFromHexString(ModernGraphicsRendererClassAdapter::DEFAULT_COLOR_HEX);
    }

    protected function tearDown(): void
    {
        unset($this->rendererAdapter);
    }

    private function isStdoutEof(): bool
    {
        return '' === $this->stdout->fread(1) && $this->stdout->eof();
    }

    private function checkLineAssertion(int $fromX, int $fromY, int $toX, int $toY, RgbaColor $color): void
    {
        $this->stdout->rewind();
        $this->assertStringContainsString('<draw>', $this->stdout->fgets());

        $expectedString = sprintf('<line fromX="%d" fromY="%d" toX="%d" toY="%d"/>', $fromX, $fromY, $toX, $toY);
        $this->assertStringContainsString($expectedString, $this->stdout->fgets());

        $expectedString = sprintf('<color r="%f" g="%f" b="%f" a="%f"/>', $color->getR(), $color->getG(), $color->getB(), $color->getAlpha());
        $this->assertStringContainsString($expectedString, $this->stdout->fgets());

        $expectedString = '</line>';
        $this->assertStringContainsString($expectedString, $this->stdout->fgets());

    }
}