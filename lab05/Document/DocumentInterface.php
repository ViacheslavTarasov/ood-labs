<?php
declare(strict_types=1);

namespace Lab05\Document;

interface DocumentInterface
{
    public function insertParagraph(string $text, int $position = null): ParagraphInterface;

    public function replaceText(string $text, int $position): void;

    public function insertImage(string $path, int $width, int $height, int $position = null): ImageInterface;

    public function resizeImage(int $position, int $width, int $height): void;

    public function getItemsCount(): int;

    public function getItem(int $position): ?DocumentItem;

    public function deleteItem(int $position): void;

    public function getTitle(): string;

    public function setTitle(string $title): void;

    public function canUndo(): bool;

    public function undo(): void;

    public function canRedo(): bool;

    public function redo(): void;

    public function save(string $path): void;
}