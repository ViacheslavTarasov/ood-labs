<?php
declare(strict_types=1);

namespace Lab05\Command\Document;

use Lab05\Document\DocumentItem;
use Lab05\Document\DocumentItemInterface;
use Lab05\Document\DocumentItems;
use Lab05\Document\ImageManager;

class InsertDocumentItemCommand extends AbstractCommand
{
    /** @var DocumentItems */
    private $documentItems;
    /** @var DocumentItem */
    private $item;
    /** @var int */
    private $position;
    /** @var ImageManager */
    private $imageStorage;

    public function __construct(ImageManager $imageStorage, DocumentItems $documentItems, DocumentItemInterface $item, int $position = null)
    {
        $this->imageStorage = $imageStorage;
        $this->documentItems = $documentItems;
        $this->item = $item;
        $this->position = $position ?? $documentItems->getCountItems();
    }

    public function doExecute(): void
    {
        if ($this->position < 0 || $this->position > $this->documentItems->getCountItems()) {
            throw new \InvalidArgumentException('invalid position');
        }
        $this->documentItems->add($this->item, $this->position);
    }

    public function doUnexecute(): void
    {
        $this->documentItems->deleteItem($this->position);
    }

    public function __destruct()
    {
        if ($this->item->getImage() && !$this->isExecuted()) {
            $this->imageStorage->delete($this->item->getImage()->getPath());
        }
    }
}