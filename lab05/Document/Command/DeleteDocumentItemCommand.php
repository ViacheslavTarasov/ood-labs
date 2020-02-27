<?php
declare(strict_types=1);

namespace Lab05\Document\Command;

use InvalidArgumentException;
use Lab05\Document\DocumentItem;
use Lab05\Document\DocumentItems;
use Lab05\Document\ImageManager;

class DeleteDocumentItemCommand extends AbstractCommand
{
    /** @var DocumentItems */
    private $documentItems;
    /** @var DocumentItem */
    private $item;
    /** @var int */
    private $position;
    /** @var ImageManager */
    private $imageStorage;

    public function __construct(ImageManager $imageStorage, DocumentItems $documentItems, int $position)
    {
        $this->item = $documentItems->getItem($position);
        if (!$this->item) {
            throw new InvalidArgumentException('not found in document');
        }
        $this->imageStorage = $imageStorage;
        $this->documentItems = $documentItems;
        $this->position = $position;
    }

    public function doExecute(): void
    {
        $this->documentItems->deleteItem($this->position);
    }

    public function doUnexecute(): void
    {
        $this->documentItems->add($this->item, $this->position);
    }

    public function __destruct()
    {
        if ($this->item->getImage() && $this->isExecuted()) {
            $this->imageStorage->delete($this->item->getImage()->getPath());
        }
    }
}