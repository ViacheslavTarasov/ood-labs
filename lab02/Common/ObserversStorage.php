<?php


namespace Lab02\Common;


class ObserversStorage extends \SplObjectStorage
{
    public function getArraySortedByPriority()
    {
        $this->rewind();
        $observers = [];
        foreach ($this as $observer) {
            $observers[] = ['number' => $this->getInfo(), 'observer' => $observer];
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