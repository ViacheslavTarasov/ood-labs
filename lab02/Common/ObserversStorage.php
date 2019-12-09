<?php


namespace Lab02\Common;

use SplObjectStorage;

class ObserversStorage
{
    private $storage;

    public function __construct()
    {
        $this->storage = new SplObjectStorage();
    }

    public function attach(object $object, int $priority = 0)
    {
        $this->storage->attach($object, $priority);
    }

    public function detach(object $object)
    {
        $this->storage->detach($object);
    }

    public function getArraySortedByPriority(): array
    {
        $this->storage->rewind();
        $observers = [];
        foreach ($this->storage as $observer) {
            $observers[] = ['number' => $this->storage->getInfo(), 'observer' => $observer];
        }
        usort($observers, function ($a, $b) {
            if ($a['number'] === $b['number']) {
                return 0;
            }
            return ($a['number'] < $b['number']) ? 1 : -1;
        });

        return array_column($observers, 'observer');
    }
}
