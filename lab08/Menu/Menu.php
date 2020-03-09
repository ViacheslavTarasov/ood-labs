<?php
declare(strict_types=1);

namespace Lab08\Menu;

use Exception;
use InvalidArgumentException;
use SplFileObject;

class Menu implements MenuInterface
{
    /** @var MenuItem[] */
    private $items = [];
    private $exit = false;

    /** @var SplFileObject */
    private $stdin;
    /** @var SplFileObject */
    private $stdout;

    public function __construct(SplFileObject $stdin, SplFileObject $stdout)
    {
        $this->stdin = $stdin;
        $this->stdout = $stdout;
    }

    public function addItem(MenuItem $menuItem): void
    {
        $this->items[$menuItem->getShortcut()] = $menuItem;
    }

    public function showInstruction(): void
    {
        $this->stdout->fwrite('Commands list:' . PHP_EOL);
        foreach ($this->items as $menuItem) {
            $this->stdout->fwrite('    ' . $menuItem->getShortcut() . ': ' . $menuItem->getDescription() . PHP_EOL);
        }
    }

    public function run(): void
    {
        $execute = true;
        do {
            $this->stdout->fwrite('>');
            $line = trim($this->stdin->fgets());
            try {
                $execute = $this->executeCommand($line);
            } catch (InvalidArgumentException $e) {
                $this->stdout->fwrite($e->getMessage() . PHP_EOL);
            } catch (Exception $e) {
                $this->stdout->fwrite($e->getMessage() . PHP_EOL);
            }

        } while ($execute);

    }

    public function executeCommand(string $line): bool
    {
        $this->exit = false;
        $shortcut = $this->extractShortcut($line);
        $arguments = $this->extractArguments($line);
        $menuItem = $this->getItemByShortcut($shortcut);
        if ($menuItem === null) {
            throw new InvalidArgumentException('unknown command' . PHP_EOL);
        }
        $menuItem->getCommand()->execute($arguments);
        return !$this->exit;
    }

    private function extractShortcut(string $line): string
    {
        preg_match('/^\s*(?<shortcut>\S+)/', $line, $matches);
        return $matches['shortcut'] ?? '';
    }

    private function extractArguments(string $line): string
    {
        preg_match('/^\s*\S+\s+(?<arguments>.*\S)\s*$/', $line, $matches);
        return $matches['arguments'] ?? '';
    }

    private function getItemByShortcut(string $shortcut): ?MenuItem
    {
        return $this->items[$shortcut] ?? null;
    }

    public function exit(): void
    {
        $this->exit = true;
    }

}