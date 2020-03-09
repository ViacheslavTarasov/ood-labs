<?php
declare(strict_types=1);

namespace Lab08\Menu;

class MenuItem
{
    /** @var string */
    private $shortcut;
    /** @var string */
    private $description;
    /** @var MenuCommandInterface */
    private $command;

    public function __construct(string $shortcut, string $description, MenuCommandInterface $command)
    {
        $this->shortcut = $shortcut;
        $this->description = $description;
        $this->command = $command;
    }

    public function getShortcut(): string
    {
        return $this->shortcut;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCommand(): MenuCommandInterface
    {
        return $this->command;
    }
}