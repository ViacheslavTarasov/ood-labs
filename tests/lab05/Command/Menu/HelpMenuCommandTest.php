<?php
declare(strict_types=1);

use Lab05\Command\Menu\HelpMenuCommand;
use Lab05\Menu\MenuInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class HelpMenuCommandTest extends TestCase
{
    /** @var HelpMenuCommand */
    private $command;
    /** @var MenuInterface|MockObject */
    private $mockMenu;

    public function testCalledShowInstructionWhenExecute(): void
    {
        $this->mockMenu->expects($this->once())->method('showInstruction');
        $this->command->execute('');
    }

    protected function setUp(): void
    {
        $this->mockMenu = $this->createMock(MenuInterface::class);
        $this->command = new HelpMenuCommand($this->mockMenu);
    }
}
