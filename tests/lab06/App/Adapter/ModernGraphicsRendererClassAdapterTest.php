<?php
declare(strict_types=1);

use Lab06\App\Adapter\ModernGraphicsRendererClassAdapter;
use PHPUnit\Framework\TestCase;

class ModernGraphicsRendererClassAdapterTest extends TestCase
{
    private const FROM_X = 50;
    private const FROM_Y = 70;
    private const TO_X = 150;
    private const TO_Y = 250;

    /** @var ModernGraphicsRendererClassAdapter */
    private $rendererAdapter;
    /** @var SplTempFileObject */
    private $stdout;

    public function testStdoutIsEmptyAfterInit(): void
    {
        $this->assertEquals('', $this->stdout->fread(1));
        $this->assertTrue($this->stdout->eof());
    }

    public function testBeginDrawWrittenInStdout(): void
    {
        $this->rendererAdapter->beginDraw();
        $this->stdout->rewind();
        $this->assertEquals('<draw>' . PHP_EOL, $this->stdout->fgets());
        $this->assertTrue($this->eofStdout());
    }

    public function testThrowsExceptionTwoCallBeginDraw(): void
    {
        $this->expectException(LogicException::class);
        $this->rendererAdapter->beginDraw();
        $this->rendererAdapter->beginDraw();
    }

    public function testThrowsExceptionEndDrawBeforeBeginDraw(): void
    {
        $this->expectException(LogicException::class);
        $this->rendererAdapter->endDraw();
    }

    public function testBeginDrawAndEndDrawWrittenInStdout(): void
    {
        $this->rendererAdapter->beginDraw();
        $this->rendererAdapter->endDraw();
        $this->stdout->rewind();
        $this->assertEquals('<draw>' . PHP_EOL, $this->stdout->fgets());
        $this->assertEquals('</draw>' . PHP_EOL, $this->stdout->fgets());
        $this->assertTrue($this->eofStdout());
    }

    public function testThrowsExceptionTwoCallEndDraw(): void
    {
        $this->rendererAdapter->beginDraw();
        $this->rendererAdapter->endDraw();
        $this->expectException(LogicException::class);
        $this->rendererAdapter->endDraw();
    }

    public function testNothingWrittenAfterMoveTo(): void
    {
        $this->rendererAdapter->moveTo(self::FROM_X, self::FROM_Y);
        $this->stdout->rewind();
        $this->assertEquals('', $this->stdout->fread(1));
        $this->assertTrue($this->stdout->eof());
    }

    public function testThrowsExceptionLineToWithoutBeginDraw(): void
    {
        $this->expectException(LogicException::class);
        $this->rendererAdapter->lineTo(10, 20);
    }

    public function testWrittenLineFromStartPointWithoutCallsMoveTo(): void
    {
        $this->rendererAdapter->beginDraw();
        $this->rendererAdapter->lineTo(self::TO_X, self::TO_Y);
        $this->stdout->rewind();
        $this->assertStringContainsString('<draw>', $this->stdout->fgets());

        $expectedString = '<line fromX="0" fromY="0" toX="' . self::TO_X . '" toY="' . self::TO_Y . '"/>';
        $this->assertStringContainsString($expectedString, $this->stdout->fgets());
    }

    public function testCorrectlyWrittenWhenMoveToAndLineTo(): void
    {
        $this->rendererAdapter->beginDraw();
        $this->rendererAdapter->moveTo(self::FROM_X, self::FROM_Y);
        $this->rendererAdapter->lineTo(self::TO_X, self::TO_Y);

        $this->stdout->rewind();
        $this->assertStringContainsString('<draw>', $this->stdout->fgets());

        $expectedString = '<line fromX="' . self::FROM_X . '" fromY="' . self::FROM_Y . '" toX="' . self::TO_X . '" toY="' . self::TO_Y . '"/>';
        $this->assertStringContainsString($expectedString, $this->stdout->fgets());
    }

    protected function setUp(): void
    {
        $this->stdout = new SplTempFileObject();
        $this->rendererAdapter = new ModernGraphicsRendererClassAdapter($this->stdout);
    }

    protected function tearDown(): void
    {
        unset($this->rendererAdapter);
    }


    private function eofStdout(): bool
    {
        return '' === $this->stdout->fread(1) && $this->stdout->eof();
    }
}