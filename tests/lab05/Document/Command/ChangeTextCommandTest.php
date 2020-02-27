<?php
declare(strict_types=1);

use Lab05\Document\Command\ChangeTextCommand;
use PHPUnit\Framework\TestCase;

class ChangeTextCommandTest extends TestCase
{
    private const TEST_TEXT = 'text';
    private const NEW_TEXT = 'new text';
    /** @var ChangeTextCommand */
    private $command;
    /** @var string */
    private $text;

    public function testChangeTextAfterExecute(): void
    {
        $this->assertEquals(self::TEST_TEXT, $this->text);
        $this->command->execute();
        $this->assertEquals(self::NEW_TEXT, $this->text);
    }

    public function testRestoreTextAfterExecuteAndUnexecute(): void
    {
        $this->command->execute();
        $this->command->unexecute();
        $this->assertEquals(self::TEST_TEXT, $this->text);
    }

    public function testTextNotChangeAfterUnexecute(): void
    {
        $this->command->unexecute();
        $this->assertEquals(self::TEST_TEXT, $this->text);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->text = self::TEST_TEXT;
        $this->command = new ChangeTextCommand($this->text, self::NEW_TEXT);
    }
}
