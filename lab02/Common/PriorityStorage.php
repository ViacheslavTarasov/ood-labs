<?php


namespace Lab02\Common;


use Iterator;

class PriorityStorage implements Iterator
{
    private $storage = [];

    public function attach(object $object, int $priority = 0)
    {
        if (null !== $this->indexOf($object)) {
            return;
        }

        $this->storage[] = [
            'priority' => $priority,
            'hash' => spl_object_hash($object),
            'object' => $object
        ];

        usort($this->storage, function ($a, $b) {
            if ($a['priority'] === $b['priority']) {
                return 0;
            }
            return ($a['priority'] < $b['priority']) ? 1 : -1;
        });
    }

    public function detach(object $object)
    {
        $index = $this->indexOf($object);
        if (!is_null($index)) {
            unset($this->storage[$index]);
        }
    }

    private function indexOf(object $object): ?int
    {
        $objectHash = spl_object_hash($object);
        foreach ($this->storage as $key => $value) {
            if ($value['hash'] === $objectHash) {
                return $key;
            }
        }
        return null;
    }


    public function rewind()
    {
        reset($this->storage);
    }

    public function current()
    {
        return current($this->storage)['object'];
    }

    public function key()
    {
        return key($this->storage);
    }

    public function next()
    {
        return next($this->storage)['object'];
    }

    public function valid()
    {
        $key = key($this->storage);
        return $key !== null && $key !== false;
    }

}