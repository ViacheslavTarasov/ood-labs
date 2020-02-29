<?php
declare(strict_types=1);

use Lab05\Document\Command\ChangeTextCommand;
use Lab05\Document\Command\ResizeImageCommand;
use PHPUnit\Framework\TestCase;

class ResizeImageCommandTest extends TestCase
{
    private const WIDTH_BEFORE = 100;
    private const HEIGHT_BEFORE = 200;
    private const WIDTH_AFTER = 300;
    private const HEIGHT_AFTER = 400;

    /** @var ChangeTextCommand */
    private $command;
    /** @var int */
    private $width;
    /** @var int */
    private $height;

    public function testExecuteChangesSize(): void
    {
        $this->assertEquals(self::WIDTH_BEFORE, $this->width);
        $this->assertEquals(self::HEIGHT_BEFORE, $this->height);

        $this->command->execute();

        $this->assertEquals(self::WIDTH_AFTER, $this->width);
        $this->assertEquals(self::HEIGHT_AFTER, $this->height);
    }

    public function testExecuteAndUnexecuteRestoreSize(): void
    {
        $this->command->execute();
        $this->command->unexecute();
        $this->assertEquals(self::WIDTH_BEFORE, $this->width);
        $this->assertEquals(self::HEIGHT_BEFORE, $this->height);
    }

    public function testNothingWillHappenIfCallUnexecuteFirst(): void
    {
        $this->command->unexecute();
        $this->assertEquals(self::WIDTH_BEFORE, $this->width);
        $this->assertEquals(self::HEIGHT_BEFORE, $this->height);
    }

    protected function setUp(): void
    {
        $this->width = self::WIDTH_BEFORE;
        $this->height = self::HEIGHT_BEFORE;
        $this->command = new ResizeImageCommand($this->width, $this->height, self::WIDTH_AFTER, self::HEIGHT_AFTER);
    }
}
