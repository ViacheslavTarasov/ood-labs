<?php
declare(strict_types=1);

namespace Lab05\Document;

use Iterator;

class DocumentItems implements Iterator
{
    private $items = [];

    public function add(DocumentItemInterface $item, int $position = null)
    {
        if ($position < 0 || $position > $this->getCountItems()) {
            throw new \InvalidArgumentException('invalid position');
        }

        if ($position === null) {
            $this->items[] = $item;
        } else {
            array_splice($this->items, $position, 0, [$item]);
        }
    }

    public function getCountItems(): int
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

    public function getItem(int $position): ?DocumentItemInterface
    {
        return $this->items[$position] ?? null;
    }

    public function rewind(): void
    {
        reset($this->items);
    }

    public function current()
    {
        return current($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function next()
    {
        return next($this->items);
    }

    public function valid(): bool
    {
        $key = key($this->items);
        return $key !== null && $key !== false;
    }
}