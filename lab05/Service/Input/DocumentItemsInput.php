<?php
declare(strict_types=1);

namespace Lab05\Service\Input;

use ArrayIterator;
use IteratorAggregate;

class DocumentItemsInput implements IteratorAggregate
{
    /** @var array */
    private $items;

    public function __construct(array $items)
    {
        foreach ($items as $item) {
            if (!$item instanceof ParagraphInput && !$item instanceof ImageInput) {
                throw new \InvalidArgumentException('invalid item type');
            }
        }
        $this->items = $items;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
}