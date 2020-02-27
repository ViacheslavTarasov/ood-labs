<?php
declare(strict_types=1);

namespace Lab05\Document;

use ArrayIterator;
use IteratorAggregate;

class DocumentItems implements IteratorAggregate
{
    private $items = [];

    public function add(DocumentItem $item, int $position = null): void
    {
        if ($position < 0 || $position > $this->getItemCount()) {
            throw new \InvalidArgumentException('invalid position');
        }

        if ($position === null) {
            $this->items[] = $item;
        } else {
            array_splice($this->items, $position, 0, [$item]);
        }
    }

    public function getItemCount(): int
    {
        return count($this->items);
    }

    public function deleteItem(int $position): void
    {
        if (!isset($this->items[$position])) {
            throw new \InvalidArgumentException('invalid position');
        }
        array_splice($this->items, $position, 1);
    }

    public function getItem(int $position): ?DocumentItem
    {
        return $this->items[$position] ?? null;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
}