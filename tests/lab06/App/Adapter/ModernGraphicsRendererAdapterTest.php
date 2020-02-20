<?php
declare(strict_types=1);

use Lab06\App\Adapter\ModernGraphicsRendererAdapter;
use Lab06\ModernGraphicsLib\ModernGraphicsRenderer;
use PHPUnit\Framework\TestCase;

class ModernGraphicsRendererAdapterTest extends TestCase
{
    private const FROM_X = 50;
    private const FROM_Y = 70;
    private const TO_X = 150;
    private const TO_Y = 250;

    /** @var ModernGraphicsRendererAdapter */
    private $rendererAdapter;
    /** @var SplTempFileObject */
    private $stdout;

    public function testWrittenDrawInStdoutAfterInit(): void
    {
        $this->stdout->rewind();
        $this->assertEquals('<draw>' . PHP_EOL, $this->stdout->fgets());
        $this->assertTrue($this->eofStdout());
    }

    public function testWrittenEndDrawInStdoutAfterDestruct(): void
    {
        unset($this->rendererAdapter);
        $this->stdout->rewind();
        $this->assertEquals('<draw>' . PHP_EOL, $this->stdout->fgets());
        $this->assertEquals('</draw>' . PHP_EOL, $this->stdout->fgets());
        $this->assertTrue($this->eofStdout());
    }

    public function testNothingWrittenAfterMoveTo(): void
    {
        $this->rendererAdapter->moveTo(self::FROM_X, self::FROM_Y);
        $this->stdout->rewind();
        $this->assertEquals('<draw>' . PHP_EOL, $this->stdout->fgets());
        $this->assertTrue($this->eofStdout());
    }

    public function testWrittenWhenCallsLineToWithoutMoveTo(): void
    {
        $this->rendererAdapter->lineTo(self::TO_X, self::TO_Y);
        $this->checkLineAssertion(0, 0, self::TO_X, self::TO_Y);
    }

    public function testWrittenInStdoutWhenMoveToAndLineTo(): void
    {
        $this->rendererAdapter->moveTo(self::FROM_X, self::FROM_Y);
        $this->rendererAdapter->lineTo(self::TO_X, self::TO_Y);
        $this->checkLineAssertion(self::FROM_X, self::FROM_Y, self::TO_X, self::TO_Y);
    }

    protected function setUp(): void
    {
        $this->stdout = new SplTempFileObject();
        $this->rendererAdapter = new ModernGraphicsRendererAdapter(New ModernGraphicsRenderer($this->stdout));
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