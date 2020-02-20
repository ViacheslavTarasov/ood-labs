<?php
declare(strict_types=1);

use Lab06\App\Adapter\ModernGraphicsRendererClassAdapter;
use Lab06\ModernGraphicsLib\Point;
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

    public function testThrowsExceptionDrawLineBeforeBeginDraw(): void
    {
        $p1 = new Point(self::FROM_X, self::FROM_Y);
        $p2 = new Point(self::TO_X, self::TO_Y);

        $this->expectException(LogicException::class);
        $this->rendererAdapter->drawLine($p1, $p2);
    }

    public function testWrittenLineAfterDrawLine(): void
    {
        $p1 = new Point(self::FROM_X, self::FROM_Y);
        $p2 = new Point(self::TO_X, self::TO_Y);
        $this->rendererAdapter->beginDraw();
        $this->rendererAdapter->drawLine($p1, $p2);

        $this->checkLineAssertion(self::FROM_X, self::FROM_Y, self::TO_X, self::TO_Y);
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

        $this->checkLineAssertion(0, 0, self::TO_X, self::TO_Y);
    }

    public function testCorrectlyWrittenWhenMoveToAndLineTo(): void
    {
        $this->rendererAdapter->beginDraw();
        $this->rendererAdapter->moveTo(self::FROM_X, self::FROM_Y);
        $this->rendererAdapter->lineTo(self::TO_X, self::TO_Y);

        $this->checkLineAssertion(self::FROM_X, self::FROM_Y, self::TO_X, self::TO_Y);
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

    private function checkLineAssertion(int $fromX, int $fromY, int $toX, int $toY): void
    {
        $this->stdout->rewind();
        $this->assertStringContainsString('<draw>', $this->stdout->fgets());

        $expectedString = sprintf('<line fromX="%d" fromY="%d" toX="%d" toY="%d"/>', $fromX, $fromY, $toX, $toY);
        $this->assertStringContainsString($expectedString, $this->stdout->fgets());
    }
}