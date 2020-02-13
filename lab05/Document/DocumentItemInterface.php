<?php
declare(strict_types=1);

namespace Lab05\Document;

interface DocumentItemInterface
{
    public function getImage(): ?ImageInterface;

    public function getParagraph(): ?ParagraphInterface;
}