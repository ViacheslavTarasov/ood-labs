<?php
declare(strict_types=1);

namespace Lab05\Document;

use Lab05\Document\Command\ResizeImageCommand;
use Lab05\History\CommandExecutantInterface;

class Image implements ImageInterface
{
    public const MIN_SIZE = 1;
    public const MAX_SIZE = 10000;

    /** @var CommandExecutantInterface */
    private $commandExecutant;
    /** @var string */
    private $path;
    /** @var int */
    private $width;
    /** @var int */
    private $height;

    public function __construct(CommandExecutantInterface $commandExecutant, string $path, int $width, int $height)
    {
        $this->checkSize($width, $height);
        $this->commandExecutant = $commandExecutant;
        $this->path = $path;
        $this->width = $width;
        $this->height = $height;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function resize(int $width, int $height): void
    {
        $this->checkSize($width, $height);
        $command = new ResizeImageCommand($this->width, $this->height, $width, $height);
        $this->commandExecutant->addAndExecuteCommand($command);
    }

    private function checkSize(int $width, int $height): void
    {
        if ($width < self::MIN_SIZE || $width > self::MAX_SIZE) {
            throw new \InvalidArgumentException('invalid width');
        }
        if ($height < self::MIN_SIZE || $height > self::MAX_SIZE) {
            throw new \InvalidArgumentException('invalid width');
        }
    }
}