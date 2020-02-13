<?php
declare(strict_types=1);

namespace Lab05\Document;

use InvalidArgumentException;
use Lab05\Command\Document\ChangeTextCommand;
use Lab05\Command\Document\DeleteDocumentItemCommand;
use Lab05\Command\Document\InsertDocumentItemCommand;
use Lab05\Command\Document\ResizeImageCommand;
use RuntimeException;

class Document implements DocumentInterface
{
    public const DEFAULT_TITLE = '';
    public const IMAGES_DIR = __DIR__ . '/images';

    /** @var HistoryInterface */
    private $history;
    /** @var DocumentItems */
    private $items;
    /** @var string */
    private $title;
    /** @var ImageManager */
    private $imageManager;
    /** @var DocumentSavingService */
    private $savingService;

    public function __construct(HistoryInterface $history, ImageManager $imageManager, DocumentSavingService $savingService)
    {
        $this->history = $history;
        $this->items = new DocumentItems();
        $this->title = self::DEFAULT_TITLE;
        $this->imageManager = $imageManager;
        $this->savingService = $savingService;
    }

    public function insertParagraph(string $text, int $position = null): ParagraphInterface
    {
        $paragraph = new Paragraph($this->history, $text);
        $command = new InsertDocumentItemCommand($this->imageManager, $this->items, new DocumentItem($paragraph), $position);
        $this->history->addAndExecuteCommand($command);
        return $paragraph;
    }

    public function replaceText($text, int $position): void
    {
        $item = $this->getItem($position);
        if ($item === null || !$item->getParagraph() instanceof ParagraphInterface) {
            throw new InvalidArgumentException('Invalid position');
        }
        $item->getParagraph()->setText($text);
    }


    public function insertImage(string $path, int $width, int $height, int $position = null): ImageInterface
    {
        $newPath = $this->imageManager->save($path, self::IMAGES_DIR);
        $image = new Image($newPath, $width, $height);
        $command = new InsertDocumentItemCommand($this->imageManager, $this->items, new DocumentItem($image), $position);
        $this->history->addAndExecuteCommand($command);
        return $image;
    }

    public function resizeImage(int $position, int $width, int $height): void
    {
        $item = $this->getItem($position);
        if ($item === null || !$item->getImage() instanceof ImageInterface) {
            throw new InvalidArgumentException('Invalid position');
        }
        $this->history->addAndExecuteCommand(new ResizeImageCommand($item->getImage(), $width, $height));
    }


    public function getItemsCount(): int
    {
        return $this->items->getCountItems();
    }

    public function getItem(int $position): ?DocumentItemInterface
    {
        return $this->items->getItem($position);
    }

    public function deleteItem(int $position): void
    {
        $this->history->addAndExecuteCommand(new DeleteDocumentItemCommand($this->imageManager, $this->items, $position));
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->history->addAndExecuteCommand(new ChangeTextCommand($this->title, $title));
    }

    public function canUndo(): bool
    {
        return $this->history->canUndo();
    }

    public function undo(): void
    {
        if (!$this->canUndo()) {
            throw new RuntimeException('can not undo');
        }
        $this->history->undo();
    }

    public function canRedo(): bool
    {
        return $this->history->canRedo();
    }

    public function redo(): void
    {
        if (!$this->canRedo()) {
            throw new RuntimeException('can not redo');
        }
        $this->history->redo();
    }

    public function save(string $path): void
    {
        $this->savingService->saveAsHtml($path, $this->title, $this->items);
    }

}