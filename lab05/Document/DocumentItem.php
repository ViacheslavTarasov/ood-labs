<?php
declare(strict_types=1);

namespace Lab05\Document;

class DocumentItem implements DocumentItemInterface
{
    private $imageOrParagraph;

    public function __construct(object $imageOrParagraph)
    {
        if (!$imageOrParagraph instanceof ImageInterface && !$imageOrParagraph instanceof ParagraphInterface) {
            throw new \DomainException('argument must be Image or Paragraph');
        }
        $this->imageOrParagraph = $imageOrParagraph;
    }

    public function getImage(): ?ImageInterface
    {
        return $this->imageOrParagraph instanceof ImageInterface ? $this->imageOrParagraph : null;
    }

    public function getParagraph(): ?ParagraphInterface
    {
        return $this->imageOrParagraph instanceof ParagraphInterface ? $this->imageOrParagraph : null;
    }
}