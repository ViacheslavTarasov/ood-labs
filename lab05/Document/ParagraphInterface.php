<?php
declare(strict_types=1);

namespace Lab05\Document;

interface ParagraphInterface
{
    public function getText(): string;

    public function setText(string $text): void;
}