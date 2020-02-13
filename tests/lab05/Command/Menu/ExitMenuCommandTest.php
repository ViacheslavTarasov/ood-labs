<?php
declare(strict_types=1);

use Lab05\Command\Menu\ExitMenuCommand;
use Lab05\Menu\MenuInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ExitMenuCommandTest extends TestCase
{
    /** @var ExitMenuCommand */
    private $command;
    /** @var MenuInterface|MockObject */
    private $mockMenu;

    public function testCalledExitWhenExecute(): void
    {
        $this->mockMenu->expects($this->once())->method('exit');
        $this->command->execute('');
    }

    protected function setUp(): void
    {
        $this->mockMenu = $this->createMock(MenuInterface::class);
        $this->command = new ExitMenuCommand($this->mockMenu);
    }
}